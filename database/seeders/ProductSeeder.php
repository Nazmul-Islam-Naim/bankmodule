<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Services\LanguageService;
use App\Services\ProductService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ProductService = new ProductService();
        $languages              = LanguageService::instance()->getAvailableLanguagesCode();
        $variations  = array(
            ['product_id' => '1', 'unit_id'=>'1', 'unit_price' => '500', 'quantity'=>'1', 'color'=>["red"], 'size'=>["XL"]],
            ['product_id' => '1', 'unit_id'=>'1', 'unit_price' => '500', 'quantity'=>'1', 'color'=>["gray"], 'size'=>["XL"]],
        );
        $galleries  = array(
            ['product_id' => '1', 'image'=>'image.jpg'],
            ['product_id' => '1', 'image'=>'image2.jpg']
        );
        $productId = 1;

        $ProductService->store([
            'slug' => 't-shirt',
            'tag' => json_encode(["t-shirt","shirt"]),
            'vendor_id' => '1',
            'category_id'=>'1',
            'brand_id'=>'1',
            'is_featured' => '1',
            'quantity_warning'=> '1',
            'status'=> '1',
            'translations'=> $this->getTranslations($languages,$productId),
            
            'variations'  => $variations,
            'galleries'  => $galleries
        ]);
    }

    private function getTranslations($languages,$productId){
        foreach($languages as $language){
            $translations[$language] = [
                'local'=>$language,
                'product_id'=>$productId,
                'title'=>'T-shirt '.$language,
                'short_details'=>'This is product short details',
                'long_details'=>'This is product Long details',
                'properties'=> ["property 1", "property 2"],
            ];
        }

        return $translations;
    }
}
