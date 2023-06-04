<?php

namespace Database\Seeders;

use App\Actions\DispatchService;
use App\Services\DeliveryService;
use App\Services\LanguageService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DeliverySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $deliveries = [
            ['title'=>'Express', 'description'=>'Delivery within 1 hour', 'amount'=>150],
            ['title'=>'Standard', 'description'=>'Delivery with in 7 days', 'amount'=>100],
            ['title'=>'Economy', 'description'=>'Delivery with in 30 days', 'amount'=>100],
        ];

        $deliveryService = new DeliveryService();
        $dispatchService      = new DispatchService($deliveryService);
        $languages            = LanguageService::instance()->getAvailableLanguagesCode();


        foreach($deliveries as $delivery){
            $dispatchService->store([
                'amount'=>$delivery['amount'],
                'translations' => $this->getTranslations($languages,$delivery),
            ]);
        }

    }

    private function getTranslations($languages,$delivery)
    {
        $translations = [];
        foreach ($languages as $language) {
            array_push($translations, [
                'local' => $language,
                'title' => $language . '' . $delivery['title'],
                'description' => $delivery['description'],
            ]);
        }

        return $translations;
    }
}
