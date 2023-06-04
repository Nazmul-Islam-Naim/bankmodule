<?php

namespace Database\Seeders;


use App\Services\TemplateService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Str;

class TemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $templeteService           = new TemplateService();
        
        	$brandId = 1;
        $templeteService->store([
            'title' => 'Clothing',
            'slug' => Str::slug('Clothing'),
        ]);
        
    }


}
