<?php

namespace App\Console\Commands;

use App\Actions\CreateProductAction;
use App\Models\Product;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CreateProductCommand extends Command
{
    protected $signature = 'app:create-product-command {title?} {user?}';

    protected $description = 'Command description';

    public function handle(): void
    {
        $title = $this->argument('title');
        $user = $this->argument('user');

        if(!$user)
        {
             $user = $this->components->ask('Por favor, preciso de um ID valido ❗');
        }

        if(!$title)
        {
            $title = $this->components->ask('Por favor, preciso de um titulo de produto valido ❗');
        }

        Validator::make(['title' => $title,  'user' => $user], [
           'title' => ['required', 'string', 'min:3'],
            'user' => ['required', Rule::exists('users', 'id')],
        ])->validate();

        app(CreateProductAction::class)
            ->handle(
            $title, User::findOrFail($user)
        );

//        Product::query()
//            ->create([
//                'title' => $title,
//                'owner_id' => $user
//            ]);

        $this->components->info('Produto criado 🤙');

    }
}
