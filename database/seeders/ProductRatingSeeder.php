<?php

namespace Database\Seeders;

use App\Services\ProductRatingService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductRatingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ratingService = new ProductRatingService();

        $ratingService->store([
            'product_id' => '1',
            'customer_id' => '1',
            'star' => '3',
            'comment' => 'nice',
        ]);
    }
}
