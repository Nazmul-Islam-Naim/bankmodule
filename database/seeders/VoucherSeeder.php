<?php

namespace Database\Seeders;

use App\Services\VoucherService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VoucherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $voucherService = new VoucherService();
        $voucherService->store([
            'voucher_code' => 'TEST-204',
            // 'customer_id' => 1,
            // 'vendor_id' => 1,
            'value' => 100,
            'uses' =>1,
            'max_uses'=> 2,
            'status'=> 1,
            'expires_at' => now()
        ]);
    }
}
