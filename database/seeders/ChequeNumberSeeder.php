<?php

namespace Database\Seeders;

use App\Enum\ChequeStatus;
use App\Services\ChequeBookService;
use App\Services\ChequeNumberService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Crypt;

class ChequeNumberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $chequeNumberService = new ChequeNumberService();
        $chequeBooks = new ChequeBookService();
        $chequeNumberService->store([
            'cheque_book_id' => Crypt::encryptString($chequeBooks->index()->first()->id),
            'cheque_number' => '123-456-78901234-567',
            'status' => ChequeStatus::getFromName('Unused')->value
        ]);
    }
}
