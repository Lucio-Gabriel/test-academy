<?php

use App\Jobs\ImportProductsJob;
use App\Mail\WelcomeEmail;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
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

    request()->validate([
        'title' => 'required|max:255'
    ]);

    Product::query()
        ->create([
            'title' => request()->only('title'),
            'owner_id' => auth()->id()
        ]);

    auth()->user()->notify(
        new \App\Notifications\NewProductionNotification()
    );

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

Route::post('/import-products', function () {
    $data = request()->get('data');

    ImportProductsJob::dispatch($data, auth()->id());
})->name('product.import');

Route::post('/sending-email/{user}', function (User $user) {
    Mail::to($user)->send(new WelcomeEmail($user));
})->name('sending-email');
