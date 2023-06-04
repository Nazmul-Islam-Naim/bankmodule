<?php

namespace Database\Seeders;

use App\Services\CategoryService;
use App\Services\LanguageService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $brandService           = new CategoryService();
        $languages              = LanguageService::instance()->getAvailableLanguagesCode();
        
        $catId = 1;
        $brandService->store([
            'slug' => 'rfl',
            'properties' => '1',
            'brands' => '1',
            'template_id' => '1',
            'translations'=> $this->getTranslations($languages,$catId),
        ]);
        
    }

    
    private function getTranslations($languages,$catId){
        foreach($languages as $language){
            $translations[$language] = [
                'local'=>$language,
                'title'=>'Rfl '.$language,
                'category_id'=>$catId,
            ];
        }

        return $translations;
    }
}
