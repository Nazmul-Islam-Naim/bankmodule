<?php

namespace Database\Seeders;

use App\Services\UnitService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use illuminate\Support\Str;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $unitService = new UnitService();

        $unitTitle = ['Pcs','Box','Kg','gm', 'ltr','ml'];
        foreach($unitTitle as $title){
            $unitService->store([
                'title' => $title,
                'slug'=>Str::slug($title)
            ]);
        }
    }
}
