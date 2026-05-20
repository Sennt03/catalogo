<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductDuplicator
{
    public function duplicate(Product $product, string $suffix = ' (Copia)'): Product
    {
        // Reload a clean instance so aggregates like `variants_count` (added by
        // ->counts() in Filament tables) don't leak into the replicated attributes.
        $product = Product::with(['variants.attributeValues', 'images'])->findOrFail($product->getKey());

        return DB::transaction(function () use ($product, $suffix): Product {
            $copy = $product->replicate(['slug']);
            $copy->name = $product->name.$suffix;
            $copy->is_active = true;
            $copy->is_featured = false;
            $copy->save();

            // The ProductObserver auto-creates a default variant on `created`;
            // remove it so we can replicate the original variants cleanly.
            $copy->variants()->delete();

            $variantIdMap = [];

            foreach ($product->variants as $variant) {
                $variantCopy = $variant->replicate(['sku']);
                $variantCopy->product_id = $copy->id;
                $variantCopy->sku = $this->copySku($variant->sku);
                $variantCopy->save();

                $variantIdMap[$variant->id] = $variantCopy->id;

                $attributeValueIds = $variant->attributeValues->pluck('id')->all();
                if (! empty($attributeValueIds)) {
                    $variantCopy->attributeValues()->sync($attributeValueIds);
                }
            }

            foreach ($product->images as $image) {
                $newPath = $this->copyImageFile($image->path, $copy->id);
                if ($newPath === null) {
                    continue;
                }

                ProductImage::create([
                    'product_id' => $copy->id,
                    'product_variant_id' => $image->product_variant_id
                        ? ($variantIdMap[$image->product_variant_id] ?? null)
                        : null,
                    'path' => $newPath,
                    'alt_text' => $image->alt_text,
                    'sort_order' => $image->sort_order,
                    'is_primary' => $image->is_primary,
                ]);
            }

            return $copy->fresh(['variants', 'images']);
        });
    }

    private function copyImageFile(?string $sourcePath, int $newProductId): ?string
    {
        if (! $sourcePath) {
            return null;
        }

        $disk = Storage::disk('public');
        if (! $disk->exists($sourcePath)) {
            return null;
        }

        $extension = pathinfo($sourcePath, PATHINFO_EXTENSION) ?: 'jpg';
        $newPath = "products/{$newProductId}/".Str::ulid().'.'.$extension;

        $disk->copy($sourcePath, $newPath);

        return $newPath;
    }

    private function copySku(?string $sku): ?string
    {
        if ($sku === null || $sku === '') {
            return null;
        }

        $base = $sku.'-COPY';
        $candidate = $base;
        $i = 1;

        while (ProductVariant::where('sku', $candidate)->exists()) {
            $candidate = $base.'-'.$i++;
        }

        return $candidate;
    }
}
