<?php

namespace App\Observers;

use App\Models\Product;

class ProductObserver
{
    public function created(Product $product): void
    {
        if (! $product->has_variants) {
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
