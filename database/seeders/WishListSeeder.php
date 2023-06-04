<?php

namespace Database\Seeders;

use App\Services\WishListService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WishListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $wishListService = new WishListService();

        $wishListService->store([
            'product_id'=> 1,
            'customer_id'=> 1
        ]);
    }
}
