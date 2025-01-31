<?php

use App\Actions\CreateProductAction;
use App\Jobs\ImportProductsJob;
use App\Mail\WelcomeEmail;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use function App\Actions\CreateProductActio;

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

    $action = app(CreateProductAction::class);
    $action->handle(
        request()->get('title'),
        auth()->user(),
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

Route::get('/secure-route', fn() =>  ['oi'])
    ->middleware(\App\Http\Middleware\AdminMiddleware::class)
    ->name('secure-route');

Route::post('/upload-avatar', function () {
    $file = request()->file('file');

    $file->store(
        '/',
        options: ['disk' => 'avatar']
    );
})->name('upload-avatar');

Route::post('/import-products', function (){

    $file = request()->file('file');

    $openToRead = fopen($file->getRealPath(), 'r');

    while(($data = fgetcsv($openToRead, 1000, ',')) !== false) {

        Product::query()->create([
            'title' => $data[0],
            'owner_id' => $data[1]
        ]);
    }
})->name('import-products');
