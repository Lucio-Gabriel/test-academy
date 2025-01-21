<?php

use App\Console\Commands\CreateProductCommand;
use App\Models\User;
use function Pest\Laravel\artisan;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;

it('should be able to create product', function () {

    $user = User::factory()->create();

    artisan(
        CreateProductCommand::class,
        ['title' => 'product 1', 'user' => $user->id]
    )
        ->assertSuccessful();

    assertDatabaseHas('products', ['title' => 'product 1', 'owner_id' => $user->id]);
    assertDatabaseCount('products', 1);
});

it('should asks for user and title if is not passed as argument', function () {
    $user = User::factory()->create();

    artisan(CreateProductCommand::class, [])
        ->expectsQuestion('Por favor, preciso de um ID valido ❗', $user->id)
        ->expectsQuestion('Por favor, preciso de um titulo de produto valido ❗', 'Product 1')
        ->expectsOutputToContain('Produto criado 🤙')
        ->assertSuccessful();
});
