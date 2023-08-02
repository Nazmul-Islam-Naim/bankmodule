<?php

namespace Database\Seeders;

use App\Actions\DispatchService;
use App\Services\AccountTypeService;
use App\Services\BankAccountService;
use App\Services\BankService;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Crypt;

class BankAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bankAccountService = new BankAccountService();
        $accountTypeService = new AccountTypeService();
        $banks = new BankService();
        $types=$accountTypeService->index();
        $banks=$banks->index();

        
        $bankAccountService->store([
            'bank_id' => Crypt::encryptString($banks->first()->id),
            'account_type_id' => Crypt::encryptString($types->first()->id),
            'account_name' => 'Jamana Group',
            'account_number' => '987876543243',
            'routing_numer' => 'Uttara-20',
            'branch' => 'Uttara Dhaka 1320',
            'opening_date' => Carbon::now(),
            'balance' => '0',
        ]);
    }
}
