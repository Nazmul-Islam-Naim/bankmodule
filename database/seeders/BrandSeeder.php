<?php

namespace Database\Seeders;

use App\Services\BrandService;
use App\Services\LanguageService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Str;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $brandService           = new BrandService();
        $languages              = LanguageService::instance()->getAvailableLanguagesCode();

        $brandId = 1;
        $brandService->store([
            'slug' => 'easy-slug',
            'translations' => $this->getTranslations($languages, $brandId),
        ]);
    }


    private function getTranslations($languages, $brandId)
    {
        $translations = [];
        foreach ($languages as $key => $language) {
            array_push($translations,[
                'local' => $language,
                'title' => $key . '' . 'easy',
                'brand_id' => $brandId,
            ]);
        }
        logger()->error($translations);

        return $translations;
    }
}
