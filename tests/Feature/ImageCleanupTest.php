<?php

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Storage;

beforeEach(function (): void {
    Storage::fake('public');
});

it('deletes the old category image when image_path changes', function (): void {
    Storage::disk('public')->put('categories/old.jpg', 'old');
    Storage::disk('public')->put('categories/new.jpg', 'new');

    $category = Category::factory()->create(['image_path' => 'categories/old.jpg']);

    $category->update(['image_path' => 'categories/new.jpg']);

    Storage::disk('public')->assertMissing('categories/old.jpg');
    Storage::disk('public')->assertExists('categories/new.jpg');
});

it('deletes the category image when the category is deleted', function (): void {
    Storage::disk('public')->put('categories/foo.jpg', 'foo');

    $category = Category::factory()->create(['image_path' => 'categories/foo.jpg']);

    $category->delete();

    Storage::disk('public')->assertMissing('categories/foo.jpg');
});

it('deletes the old product image file when its path changes', function (): void {
    $product = Product::factory()->create();
    Storage::disk('public')->put("products/{$product->id}/old.jpg", 'old');
    Storage::disk('public')->put("products/{$product->id}/new.jpg", 'new');

    $image = ProductImage::factory()->create([
        'product_id' => $product->id,
        'path' => "products/{$product->id}/old.jpg",
    ]);

    $image->update(['path' => "products/{$product->id}/new.jpg"]);

    Storage::disk('public')->assertMissing("products/{$product->id}/old.jpg");
    Storage::disk('public')->assertExists("products/{$product->id}/new.jpg");
});

it('deletes the file when a product image is deleted and removes the empty directory', function (): void {
    $product = Product::factory()->create();
    Storage::disk('public')->put("products/{$product->id}/only.jpg", 'only');

    $image = ProductImage::factory()->create([
        'product_id' => $product->id,
        'path' => "products/{$product->id}/only.jpg",
    ]);

    $image->delete();

    Storage::disk('public')->assertMissing("products/{$product->id}/only.jpg");
    expect(Storage::disk('public')->exists("products/{$product->id}"))->toBeFalse();
});

it('keeps the product directory when other images remain', function (): void {
    $product = Product::factory()->create();
    Storage::disk('public')->put("products/{$product->id}/one.jpg", 'one');
    Storage::disk('public')->put("products/{$product->id}/two.jpg", 'two');

    $first = ProductImage::factory()->create([
        'product_id' => $product->id,
        'path' => "products/{$product->id}/one.jpg",
    ]);
    ProductImage::factory()->create([
        'product_id' => $product->id,
        'path' => "products/{$product->id}/two.jpg",
    ]);

    $first->delete();

    Storage::disk('public')->assertMissing("products/{$product->id}/one.jpg");
    Storage::disk('public')->assertExists("products/{$product->id}/two.jpg");
});

it('deletes all product images and removes the product directory when the product is deleted', function (): void {
    $product = Product::factory()->create();
    Storage::disk('public')->put("products/{$product->id}/a.jpg", 'a');
    Storage::disk('public')->put("products/{$product->id}/b.jpg", 'b');

    ProductImage::factory()->create([
        'product_id' => $product->id,
        'path' => "products/{$product->id}/a.jpg",
    ]);
    ProductImage::factory()->create([
        'product_id' => $product->id,
        'path' => "products/{$product->id}/b.jpg",
    ]);

    $productId = $product->id;
    $product->delete();

    Storage::disk('public')->assertMissing("products/{$productId}/a.jpg");
    Storage::disk('public')->assertMissing("products/{$productId}/b.jpg");
    expect(Storage::disk('public')->exists("products/{$productId}"))->toBeFalse();
});
