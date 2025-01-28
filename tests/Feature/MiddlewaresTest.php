<?php

use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

it('should block a request  if the  user does not have the following email: admin@admin.com', function () {

    $user = User::factory()->create(['email' => 'email@qualquer.com']);

    $admin = User::factory()->create(['email' => 'admin@admin.com']);

    actingAs($user);
    get(route('secure-route'))->assertForbidden();

    actingAs($admin);
    get(route('secure-route'))->assertOk();

});
