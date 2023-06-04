<?php

namespace Database\Seeders;

use App\Services\LanguageService;
use App\Services\OrderService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $orderService = new OrderService();
        $order_details  = array(
            ['order_id' => '1', 'vendor_id'=>'1', 'quantity' => '10', 'price'=>'500', 'shiping_charge'=>'200'],
        );
        $item_details  = array(
            ['order_id' => '1', 'vendor_id'=>'1', 'product_id' => '1', 'quantity'=>'5', 'price'=>'300'],
            ['order_id' => '1', 'vendor_id'=>'1', 'product_id' => '2', 'quantity'=>'5', 'price'=>'200'],
        );

        $orderService->store([
            'order_date' => now(),
            'customer_id' => 1,
            'coupon_id' => 1,
            'shiping_address' => 'BinaryIT tropical Alauddin Tower',
            'total_shiping_charge' => '200',
            'total_quantity' => 10,
            'total_price' => 500,
            'status' => 'Pending',

            'order_details'  => $order_details,
            'item_details'  => $item_details,
            
        ]);
    }
}
