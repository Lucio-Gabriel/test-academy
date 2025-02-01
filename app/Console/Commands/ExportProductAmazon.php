<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;
use League\Uri\Http;

class ExportProductAmazon extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:export-product-amazon';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        \Illuminate\Support\Facades\Http::withToken(config('services.amazon.api_key'))
            ->post('https://api.amazon.com/products',
            Product::all()->map(fn($p) => ['tile' => $p->title])->toArray()
        );
    }
}
