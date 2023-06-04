<?php

namespace Database\Seeders;

use App\Services\FlashSaleService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FlashSaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $flashSaleService = new FlashSaleService();

        $flashSaleService->store([
            'product_id'=> 1,
            'discount'=> 20,
			'start_time'=> now(),
            'discount_type' => 1
        ]);
    }
}
