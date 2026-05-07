<?php

namespace App\Filament\Resources\Products\RelationManagers;

use App\Services\ImageService;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class ImagesRelationManager extends RelationManager
{
    protected static string $relationship = 'images';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                FileUpload::make('path')
                    ->label('Imagen')
                    ->image()
                    ->required()
                    ->saveUploadedFileUsing(function (TemporaryUploadedFile $file): string {
                        $productId = $this->getOwnerRecord()->getKey();
                        $path = "products/{$productId}/".Str::ulid().'.jpg';
                        $directory = storage_path("app/public/products/{$productId}");

                        if (! is_dir($directory)) {
                            mkdir($directory, 0755, true);
                        }

                        app(ImageService::class)->optimize(
                            $file->getRealPath(),
                            storage_path('app/public/'.$path),
                        );

                        return $path;
                    })
                    ->columnSpanFull(),

                TextInput::make('alt_text')
                    ->label('Texto alternativo')
                    ->nullable()
                    ->maxLength(250),

                TextInput::make('sort_order')
                    ->label('Orden')
                    ->numeric()
                    ->default(0),

                Toggle::make('is_primary')
                    ->label('Imagen principal')
                    ->default(false)
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('alt_text')
            ->defaultSort('sort_order')
            ->columns([
                ImageColumn::make('path')
                    ->label('Imagen')
                    ->disk('public')
                    ->square()
                    ->size(64),

                TextColumn::make('alt_text')
                    ->label('Alt')
                    ->placeholder('—'),

                IconColumn::make('is_primary')
                    ->label('Principal')
                    ->boolean(),

                TextColumn::make('sort_order')
                    ->label('Orden')
                    ->numeric()
                    ->sortable(),
            ])
            ->filters([])
            ->headerActions([
                CreateAction::make()
                    ->after(function (Model $record): void {
                        $product = $this->getOwnerRecord();
                        if (! $product->images()->where('is_primary', true)->exists()) {
                            $record->update(['is_primary' => true]);
                        }
                    }),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
