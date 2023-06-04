<?php

namespace Database\Seeders;

use App\Services\LanguageService;
use App\Services\PropertiesParamsService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PropertiesParamsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $propertisParams = new PropertiesParamsService();
        $languages              = LanguageService::instance()->getAvailableLanguagesCode();

        $propertiesParamsId = 1;
        $propertisParams->store([
            'properties_id' => '1',
            'translations'=> $this->getTranslations($languages,$propertiesParamsId),
        ]);
        
    }

    
    private function getTranslations($languages,$propertiesParamsId){
        foreach($languages as $language){
            $translations[$language] = [
                'local'=>$language,
                'value'=>'easy',
                'properties_params_id'=>$propertiesParamsId,
            ];
        }

        return $translations;
    }
}
