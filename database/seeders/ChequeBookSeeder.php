<?php

namespace Database\Seeders;

use App\Services\BankService;
use App\Services\ChequeBookService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Crypt;

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
        $banks = new BankService();
        $chequeBookService->store([
            'bank_id' => Crypt::encryptString($banks->index()->first()->id),
            'title' => 'Islamic Bank',
            'book_number' => '123 2304 2564',
            'pages' => 10
        ]);
    }
}
