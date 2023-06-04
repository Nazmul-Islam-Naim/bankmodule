<?php

namespace Database\Seeders;

use App\Services\ShippingService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShippingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $shippingService = new ShippingService();
        $shippingService->store([
            'order_details_id' => 1,
            'tracking_number'=> 'TRA-654',
            'address' => 'North Carolina,53/A',
            'shipping_cost' => 400,
            'estimated_delivery_date' => now(),
            'status' => 1,
        ]);
    }
}
