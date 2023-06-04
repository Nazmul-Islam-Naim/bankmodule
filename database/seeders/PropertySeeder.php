<?php

namespace Database\Seeders;

use App\Services\LanguageService;
use App\Services\PropertyService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $propertiesService = new PropertyService();
        $languages              = LanguageService::instance()->getAvailableLanguagesCode();
        $propertiesId = 1;
        $propertiesService->store([
            'slug' => 'color',
            'translations'=> $this->getTranslations($languages,$propertiesId),
        ]);
    }

    private function getTranslations($languages,$propertiesId){
       
        foreach($languages as $language){
            $translations[$language] = [
                'local'=>$language,
                'title'=>$language.' Color',
                'property_id'=>$propertiesId,
            ];
        }

        // dd($translations);
        return $translations;
    }
}
