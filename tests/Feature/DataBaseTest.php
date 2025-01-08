<?php

use App\Models\Product;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\postJson;
use function PHPUnit\Framework\assertTrue;

it('should be able o create a product', function () {

    postJson(
        route('product.store'),
        ['title' => 'Titulo qualquer']
    )->assertCreated();

    assertDatabaseHas('products', ['title' => 'Titulo qualquer']);

    assertTrue(
        Product::query()
            ->where('title', '=', 'Titulo qualquer')
            ->exists()
    );

    assertDatabaseCount('products', 1);
});

it('should be able to update a product', function () {

})->todo();

it('should be able to delete a product', function () {

})->todo();
