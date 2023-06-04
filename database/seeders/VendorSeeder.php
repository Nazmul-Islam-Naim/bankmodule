<?php

namespace Database\Seeders;

use App\Actions\DispatchService;
use App\Services\LanguageService;
use App\Services\VendorService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Crypt;
use PhpParser\Node\Stmt\Foreach_;

class VendorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $vendorService        = new VendorService();
        $languages            = LanguageService::instance()->getAvailableLanguagesCode();
        $dispatchService      = new DispatchService($vendorService);

        $dispatchService->store([
            'vendorid'=>rand(9,99999),
            'phone'=>'012345678900',
            'email'=>'vendor@mail.com',
            'password'=>'password',
            'translations'=> $this->getTranslations($languages),
        ]);
    }




    private function getTranslations($languages){
        foreach($languages as $language){
            $translations[$language] = [
                'local'=>$language,
                'first_name'=>'Alex'.$language,
                'last_name'=>'Von'.$language,
                'shop_name'=>'electronics'.$language,
            ];
        }

        return $translations;
    }
}
