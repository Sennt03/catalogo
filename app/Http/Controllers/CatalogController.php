<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class CatalogController extends Controller
{
    public function index(): View
    {
        $categories = Category::query()
            ->where('is_active', true)
            ->whereNull('parent_id')
            ->orderBy('sort_order')
            ->get();

        return view('catalogo.index', compact('categories'));
    }

    public function category(Category $category): View
    {
        abort_if(! $category->is_active, 404);

        $products = $category->products()
            ->where('is_active', true)
            ->with([
                'primaryImage',
                'defaultVariant',
                'variants' => fn ($q) => $q->where('is_active', true)->orderBy('sort_order'),
            ])
            ->orderBy('sort_order')
            ->get();

        return view('catalogo.categoria', compact('category', 'products'));
    }

    public function product(Product $product): JsonResponse
    {
        abort_if(! $product->is_active, 404);

        $product->load([
            'images',
            'variants' => fn ($q) => $q->where('is_active', true)->with(['attributeValues.attribute', 'images']),
        ]);

        $attributeGroups = [];
        foreach ($product->variants as $variant) {
            foreach ($variant->attributeValues as $av) {
                $attrId = $av->attribute_id;
                if (! isset($attributeGroups[$attrId])) {
                    $attributeGroups[$attrId] = [
                        'attribute_id' => $attrId,
                        'name' => $av->attribute->name,
                        'slug' => $av->attribute->slug,
                        'values' => [],
                        '_seen' => [],
                    ];
                }
                if (! in_array($av->id, $attributeGroups[$attrId]['_seen'])) {
                    $attributeGroups[$attrId]['_seen'][] = $av->id;
                    $attributeGroups[$attrId]['values'][] = [
                        'id' => $av->id,
                        'value' => $av->value,
                        'sort_order' => $av->sort_order,
                    ];
                }
            }
        }

        foreach ($attributeGroups as &$group) {
            usort($group['values'], fn ($a, $b) => $a['sort_order'] <=> $b['sort_order']);
            unset($group['_seen']);
        }

        return response()->json([
            'id' => $product->id,
            'name' => $product->name,
            'slug' => $product->slug,
            'description' => $product->description,
            'short_description' => $product->short_description,
            'has_variants' => $product->has_variants,
            'images' => $product->images->map(fn ($img) => [
                'id' => $img->id,
                'url' => $img->path ? asset('storage/'.$img->path) : null,
                'alt' => $img->alt_text ?? $product->name,
                'is_primary' => (bool) $img->is_primary,
                'variant_id' => $img->product_variant_id,
            ]),
            'variants' => $product->variants->map(fn ($v) => [
                'id' => $v->id,
                'name' => $v->name,
                'sku' => $v->sku,
                'color_code' => $v->color_code,
                'price' => (float) $v->price,
                'compare_at_price' => $v->compare_at_price ? (float) $v->compare_at_price : null,
                'stock' => $v->stock,
                'is_active' => $v->is_active,
                'attribute_value_ids' => $v->attributeValues->pluck('id')->toArray(),
                'image_ids' => $v->images->pluck('id')->toArray(),
            ]),
            'attribute_groups' => array_values($attributeGroups),
        ]);
    }
}
