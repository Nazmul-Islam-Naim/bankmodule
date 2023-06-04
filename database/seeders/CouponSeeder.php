<?php

namespace Database\Seeders;

use App\Services\CouponService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $couponService = new CouponService();

        $couponService->store([
            'code' => 'ADF0123',
            'vendor_id' => 1,
            'discount'=> 150,
            'status' => 1,
            'uses'=>1,
            'discount_type' => 'percent',
            'expires_at' =>now(),
        ]);
    }
}
