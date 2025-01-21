<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;

class CreateProductCommand extends Command
{
    protected $signature = 'app:create-product-command {title} {user}';

    protected $description = 'Command description';

    public function handle(): void
    {
        $title = $this->argument('title');
        $user = $this->argument('user');

        Product::query()
            ->create([
                'title' => $title,
                'owner_id' => $user
            ]);
    }
}
