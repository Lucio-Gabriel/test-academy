<?php

use App\Models\Product;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/products', function () {
    return view('products', [
        'products' => Product::all()
    ]);
});

Route::post('/products', function () {
    Product::query()
        ->create(request()->only('title'));

    return response()->json('', '201');
})->name('product.store');

Route::put('/products/{product}', function(Product $product) {
    $product->title = request()->get('title');
    $product->save();

})->name('product.update');

Route::delete('/products/{product}', function(Product $product) {
    $product->forceDelete();
})->name('product.destroy');

Route::delete('/products/{product}/soft-delete', function(Product $product) {
    $product->delete();
})->name('product.soft-delete');
