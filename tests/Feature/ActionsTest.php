<?php

use App\Actions\CreateProductAction;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\postJson;

it('should call the action to create a product', function () {

    Notification::fake();

    $this->mock(CreateProductAction::class)
        ->shouldReceive('handle')
        ->atLeast()->once();

    $user = User::factory()->create();
    $title = 'Product 1';

    actingAs($user);

    postJson(route('product.store'), ['title' => $title]);
});
