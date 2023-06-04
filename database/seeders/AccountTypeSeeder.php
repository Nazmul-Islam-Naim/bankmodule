<?php

namespace Database\Seeders;

use App\Services\AccountTypeService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccountTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $accountTypeService           = new AccountTypeService();
        
        $accountTypeService->store([
            'title' => 'Saving',
        ]);
    }
}
