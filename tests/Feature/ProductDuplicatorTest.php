<?php

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Services\ProductDuplicator;
use Illuminate\Support\Facades\Storage;

beforeEach(function (): void {
    Storage::fake('public');
});

it('clones product attributes and marks the copy as active but not featured', function (): void {
    $product = Product::factory()->create([
        'name' => 'Vestido floral',
        'is_active' => true,
        'is_featured' => true,
        'description' => '<p>Texto bonito</p>',
    ]);

    $copy = app(ProductDuplicator::class)->duplicate($product);

    expect($copy->id)->not->toBe($product->id);
    expect($copy->name)->toBe('Vestido floral (Copia)');
    expect($copy->slug)->not->toBe($product->slug);
    expect($copy->is_active)->toBeTrue();
    expect($copy->is_featured)->toBeFalse();
    expect($copy->description)->toBe('<p>Texto bonito</p>');
    expect($copy->category_id)->toBe($product->category_id);
});

it('strips aggregate columns like variants_count before replicating', function (): void {
    $product = Product::factory()->create();

    $loaded = Product::query()->withCount('variants')->findOrFail($product->id);
    expect($loaded->variants_count)->not->toBeNull();

    $copy = app(ProductDuplicator::class)->duplicate($loaded);

    expect($copy->id)->not->toBe($product->id);
    expect($copy->exists)->toBeTrue();
});

it('clones variants and their attribute values', function (): void {
    $product = Product::factory()->withVariants()->create();
    $attribute = Attribute::factory()->create(['name' => 'Talla']);
    $small = AttributeValue::factory()->create(['attribute_id' => $attribute->id, 'value' => 'S']);
    $medium = AttributeValue::factory()->create(['attribute_id' => $attribute->id, 'value' => 'M']);

    $variantA = ProductVariant::factory()->create([
        'product_id' => $product->id,
        'sku' => 'ABC-001',
        'name' => 'Talla S',
        'price' => 100.00,
    ]);
    $variantA->attributeValues()->attach($small->id);

    $variantB = ProductVariant::factory()->create([
        'product_id' => $product->id,
        'sku' => 'ABC-002',
        'name' => 'Talla M',
        'price' => 110.00,
    ]);
    $variantB->attributeValues()->attach($medium->id);

    $copy = app(ProductDuplicator::class)->duplicate($product);

    expect($copy->variants)->toHaveCount(2);

    $copiedNames = $copy->variants->pluck('name')->all();
    expect($copiedNames)->toContain('Talla S')->toContain('Talla M');

    $copiedSkus = $copy->variants->pluck('sku')->all();
    expect($copiedSkus)->not->toContain('ABC-001');
    expect($copiedSkus)->not->toContain('ABC-002');

    foreach ($copy->variants as $variant) {
        expect($variant->product_id)->toBe($copy->id);
        expect($variant->attributeValues)->toHaveCount(1);
    }
});

it('copies physical image files into the new product folder and rewires variant images', function (): void {
    $product = Product::factory()->withVariants()->create();
    $variant = ProductVariant::factory()->create(['product_id' => $product->id]);

    Storage::disk('public')->put("products/{$product->id}/a.jpg", 'AAA');
    Storage::disk('public')->put("products/{$product->id}/b.jpg", 'BBB');

    ProductImage::factory()->create([
        'product_id' => $product->id,
        'product_variant_id' => null,
        'path' => "products/{$product->id}/a.jpg",
        'is_primary' => true,
        'sort_order' => 0,
        'alt_text' => 'Foto principal',
    ]);
    ProductImage::factory()->create([
        'product_id' => $product->id,
        'product_variant_id' => $variant->id,
        'path' => "products/{$product->id}/b.jpg",
        'is_primary' => false,
        'sort_order' => 1,
        'alt_text' => 'Variante',
    ]);

    $copy = app(ProductDuplicator::class)->duplicate($product);

    expect($copy->images)->toHaveCount(2);

    foreach ($copy->images as $image) {
        expect($image->path)->toStartWith("products/{$copy->id}/");
        expect(Storage::disk('public')->exists($image->path))->toBeTrue();
        expect($image->path)->not->toContain("products/{$product->id}/");
    }

    Storage::disk('public')->assertExists("products/{$product->id}/a.jpg");
    Storage::disk('public')->assertExists("products/{$product->id}/b.jpg");

    $variantImage = $copy->images->firstWhere('alt_text', 'Variante');
    $newVariantId = $copy->variants->first()->id;
    expect($variantImage->product_variant_id)->toBe($newVariantId);

    $primaryImage = $copy->images->firstWhere('is_primary', true);
    expect($primaryImage->product_variant_id)->toBeNull();
});

it('generates a unique slug when duplicating the same product twice', function (): void {
    $product = Product::factory()->create(['name' => 'Blusa rosa']);

    $first = app(ProductDuplicator::class)->duplicate($product);
    $second = app(ProductDuplicator::class)->duplicate($product);

    expect($first->slug)->not->toBe($second->slug);
    expect($first->slug)->not->toBe($product->slug);
});
