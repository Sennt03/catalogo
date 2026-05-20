<?php

namespace App\Filament\Resources\Products\Tables;

use App\Filament\Resources\Products\ProductResource;
use App\Models\Product;
use App\Services\ProductDuplicator;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Throwable;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('category.name')
                    ->label('Categoría')
                    ->sortable(),

                IconColumn::make('is_active')
                    ->label('Activo')
                    ->boolean(),

                IconColumn::make('is_featured')
                    ->label('Destacado')
                    ->boolean(),

                TextColumn::make('variants_count')
                    ->label('Variantes')
                    ->counts('variants')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('sort_order')
                    ->label('Orden')
                    ->numeric()
                    ->sortable(),
            ])
            ->defaultSort('sort_order')
            ->filters([])
            ->recordActions([
                EditAction::make(),
                Action::make('duplicate')
                    ->label('Duplicar')
                    ->icon(Heroicon::DocumentDuplicate)
                    ->color('gray')
                    ->requiresConfirmation()
                    ->modalHeading('Duplicar producto')
                    ->modalDescription('Se creará una copia inactiva con las mismas imágenes, variantes y categoría. Podrás editarla a continuación.')
                    ->modalSubmitActionLabel('Duplicar')
                    ->action(function (Product $record, ProductDuplicator $duplicator): void {
                        try {
                            $copy = $duplicator->duplicate($record);
                        } catch (Throwable $e) {
                            Notification::make()
                                ->title('No se pudo duplicar el producto')
                                ->body($e->getMessage())
                                ->danger()
                                ->send();

                            return;
                        }

                        Notification::make()
                            ->title('Producto duplicado')
                            ->body("Se creó la copia \"{$copy->name}\".")
                            ->success()
                            ->send();

                        redirect(ProductResource::getUrl('edit', ['record' => $copy]));
                    }),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
