<?php

namespace Database\Seeders;

use App\Actions\DispatchService;
use App\Services\AccountTypeService;
use App\Services\BankAccountService;
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
        $dispatchService      = new DispatchService($bankAccountService);
        $accountTypeService = new AccountTypeService();
        $types=$accountTypeService->index();

        
        $dispatchService->store([
            'name' => 'Dutch Bangla Bank Ltd.',
            'account_name' => 'Jamana Group',
            'account_number' => '987876543243',
            'branch' => 'Uttara Dhaka 1320',
            'type_id' => Crypt::encryptString($types->first()->id),
            'amount' => '0',
        ]);
    }
}
