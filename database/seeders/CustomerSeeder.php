<?php

namespace Database\Seeders;

use App\Services\CustomerService;
use App\Services\LanguageService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $customerService = new CustomerService();
        $languages       = LanguageService::instance()->getAvailableLanguagesCode();

        $customerService->store([
            'phone' => '01977686222',
            'email' => 'nint@gmail.com',
            'password' => 'password',
            'translations' => $this->getTranslations($languages)
        ]);
    }

    public function getTranslations($languages){
        foreach ($languages as $key => $language) {
            $translations[$language] = [
                'local' => $language,
                'name' => 'Naim'
            ];
        }

        return $translations;
    }
}
