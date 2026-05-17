<?php

namespace App\Http\Controllers;

use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PedidoController extends Controller
{
    public function show(Request $request): View
    {
        $items = $this->parseCartParam((string) $request->query('c', ''));

        $variants = ProductVariant::query()
            ->whereIn('id', array_keys($items))
            ->where('is_active', true)
            ->with(['product.primaryImage', 'attributeValues.attribute'])
            ->get()
            ->keyBy('id');

        $lines = collect($items)
            ->map(function (int $qty, int $variantId) use ($variants): ?array {
                $variant = $variants->get($variantId);
                if (! $variant || ! $variant->product) {
                    return null;
                }

                $price = (float) $variant->price;
                $image = $variant->product->primaryImage?->path
                    ? asset('storage/'.$variant->product->primaryImage->path)
                    : null;

                return [
                    'variant_id' => $variant->id,
                    'product_name' => $variant->product->name,
                    'variant_name' => $variant->name,
                    'sku' => $variant->sku,
                    'attributes' => $variant->attributeValues->map(fn ($av): array => [
                        'attribute' => $av->attribute->name,
                        'value' => $av->value,
                    ])->all(),
                    'image' => $image,
                    'price' => $price,
                    'quantity' => $qty,
                    'subtotal' => $price * $qty,
                ];
            })
            ->filter()
            ->values();

        $total = $lines->sum('subtotal');
        $itemCount = $lines->sum('quantity');

        return view('pedido.show', [
            'lines' => $lines,
            'total' => $total,
            'itemCount' => $itemCount,
            'raw' => (string) $request->query('c', ''),
        ]);
    }

    /**
     * Parse "5x2-3x1" format into [variantId => qty] sorted asc by id.
     * Sorting guarantees the same cart always produces the same URL.
     *
     * @return array<int, int>
     */
    private function parseCartParam(string $raw): array
    {
        if (trim($raw) === '') {
            return [];
        }

        $items = [];
        foreach (explode('-', $raw) as $pair) {
            if (! str_contains($pair, 'x')) {
                continue;
            }
            [$id, $qty] = explode('x', $pair, 2);
            $id = (int) $id;
            $qty = (int) $qty;
            if ($id > 0 && $qty > 0 && $qty <= 999) {
                $items[$id] = ($items[$id] ?? 0) + $qty;
            }
        }

        ksort($items);

        return $items;
    }
}
