<?php

namespace Database\Seeders;

use App\Services\BankService;
use App\Services\ChequeBookService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChequeBookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $chequeBookService = new ChequeBookService();
        $chequeBookService->store([
            'bank_id' => 1,
            'title' => 'Islamic Bank',
        ]);
    }
}
