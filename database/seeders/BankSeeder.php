<?php

namespace Database\Seeders;

use App\Actions\DispatchService;
use App\Services\BankService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $banks = [
            'AB Bank Limited',
            'Agrani Bank Limited',
            'Al-Arafah Islami Bank Limited',
            'Bangladesh Commerce Bank Limited',
        ];

        $bankService         = new BankService();
        $dispatchService      = new DispatchService($bankService);

        foreach($banks as $bank){
            $dispatchService->store([
                'title'=>$bank
            ]);
        }
    }
}
