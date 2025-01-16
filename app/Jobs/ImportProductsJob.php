<?php

namespace App\Jobs;

use App\Models\Product;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ImportProductsJob implements ShouldQueue
{
    use Queueable;


    public function __construct(
        protected readonly array $data,
        protected readonly int $ownerId
    )
    {
        //
    }

    public function handle(): void
    {
        foreach ($this->data as $data)
        {
            Product::query()->create([
                'title' => $data['title'],
                'owner_id' => $this->ownerId,
            ]);
        }
    }
}
