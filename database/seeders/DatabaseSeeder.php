<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PermissionSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(AdminSeeder::class);

        $this->call(AccountTypeSeeder::class);
        $this->call(BankSeeder::class);
        // $this->call(BankAccountSeeder::class);
        $this->call(ChequeBookSeeder::class);
        $this->call(ChequeNumberSeeder::class);

    }
}
