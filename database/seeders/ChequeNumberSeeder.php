<?php

namespace Database\Seeders;

use App\Enum\ChequeStatus;
use App\Models\ChequeBook;
use App\Models\ChequeNumber;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChequeNumberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ChequeNumber::updateOrCreate([
            'cheque_book_id' => ChequeBook::first()->id,
            'cheque_no' => 10000,
            'status' => ChequeStatus::getFromName('Unused')->value
        ]);
    }
}
