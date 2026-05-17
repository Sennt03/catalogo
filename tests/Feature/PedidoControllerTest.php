<?php

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('renders an empty state when c is missing', function () {
    $this->get(route('pedido.show'))
        ->assertOk()
        ->assertSee('Pedido vacío');
});

it('ignores invalid or missing variants', function () {
    $this->get(route('pedido.show', ['c' => '999x2']))
        ->assertOk()
        ->assertSee('Pedido vacío');
});

it('shows product details, real prices and total', function () {
    $product = Product::factory()->create(['name' => 'Vestido Rosa']);
    $variantA = ProductVariant::factory()->for($product)->create(['price' => 12.50, 'name' => 'Talla M']);
    $variantB = ProductVariant::factory()->for($product)->create(['price' => 7.00, 'name' => 'Talla S']);

    $code = "{$variantA->id}x2-{$variantB->id}x1";

    $this->get(route('pedido.show', ['c' => $code]))
        ->assertOk()
        ->assertSee('Vestido Rosa')
        ->assertSee('Talla M')
        ->assertSee('Talla S')
        ->assertSee('$12.50')
        ->assertSee('$7.00')
        ->assertSee('$32.00'); // 12.50*2 + 7.00*1
});

it('deduplicates the same variant submitted twice in the URL', function () {
    $variant = ProductVariant::factory()->create(['price' => 5.00]);

    $code = "{$variant->id}x2-{$variant->id}x3";

    $this->get(route('pedido.show', ['c' => $code]))
        ->assertOk()
        ->assertSee('$25.00'); // (2+3) * 5.00
});

it('caps unreasonable quantities', function () {
    $variant = ProductVariant::factory()->create(['price' => 1.00]);

    $code = "{$variant->id}x9999";

    $this->get(route('pedido.show', ['c' => $code]))
        ->assertOk()
        ->assertSee('Pedido vacío');
});
