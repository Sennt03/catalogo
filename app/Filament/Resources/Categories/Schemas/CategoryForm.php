<?php

namespace App\Filament\Resources\Categories\Schemas;

use App\Services\ImageService;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                Select::make('parent_id')
                    ->relationship('parent', 'name')
                    ->searchable()
                    ->nullable()
                    ->default(null)
                    ->columnSpanFull(),

                TextInput::make('name')
                    ->required()
                    ->maxLength(150),

                TextInput::make('sort_order')
                    ->numeric()
                    ->default(0),

                Textarea::make('description')
                    ->nullable()
                    ->columnSpanFull(),

                FileUpload::make('image_path')
                    ->label('Imagen')
                    ->image()
                    ->nullable()
                    ->saveUploadedFileUsing(function (TemporaryUploadedFile $file): string {
                        $path = 'categories/'.Str::ulid().'.jpg';
                        app(ImageService::class)->optimize(
                            $file->getRealPath(),
                            storage_path('app/public/'.$path),
                        );

                        return $path;
                    })
                    ->columnSpanFull(),

                Toggle::make('is_active')
                    ->default(true)
                    ->columnSpanFull(),
            ]);
    }
}
