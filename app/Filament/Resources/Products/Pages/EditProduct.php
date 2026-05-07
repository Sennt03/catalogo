<?php

namespace App\Filament\Resources\Products\Pages;

use App\Filament\Resources\Products\ProductResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        $product = $this->getRecord()->refresh();

        if (! $product->has_variants && $product->variants()->count() === 0) {
            $product->variants()->create([
                'name' => null,
                'price' => 0.00,
                'stock' => 0,
                'is_active' => true,
                'sort_order' => 0,
            ]);
        }
    }
}
