<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;

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

        Product::query()
            ->create([
                'title' => $title,
                'owner_id' => $user
            ]);

        $this->components->info('Produto criado 🤙');

    }
}
