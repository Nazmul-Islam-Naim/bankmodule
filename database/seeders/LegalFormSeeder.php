<?php

namespace Database\Seeders;

use App\Services\LegalFormService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LegalFormSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $LegalFormService = new LegalFormService();
        $LegalFormService->store([
            'title' => 'National ID',
            'slug'  =>  'national-id',
        ]);
    }
}
