<?php

use App\Console\Commands\CreateProductCommand;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use function Pest\Laravel\artisan;

it('should be able to guarantee that the user exists', function () {
    artisan(
        CreateProductCommand::class,
        ['title' => 'Gabriel', 'user' => 99]
    );

})->throws(ValidationException::class);
