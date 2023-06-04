<?php

namespace App\Repositories\Elequent;

use App\Contracts\Repositories\ProductRepositoryInterface;
use App\Contracts\Repositories\ProductRipositoryInterface;
use App\Models\Category;
use App\Models\Product;
use App\Traits\TranslationRepositoryTrait;
use Illuminate\Support\Arr;

class ProductRepository extends BaseRepository  implements ProductRepositoryInterface
{
    use TranslationRepositoryTrait;

    public $model = Product::class;

    /**
     * [Store Product]
     *
     * @param array $data
     *
     * @return Product $Product
     *
     */
    public function store($data){
        // $data['tag']=json_encode($data['tag']);
        // return Parent::store($data);

        $translations = Arr::pull($data, 'translations');
        $variations = Arr::pull($data, 'variations');
        $galleries = Arr::pull($data, 'galleries');
        $data['tag']=json_encode($data['tag']);
        return tap(Parent::store($data), function($products) use($translations,$variations,$galleries) {
            foreach($translations as $key=>$translation){
                $translation['properties']=json_encode($translation['properties']);
                $products->translations()->create($translation);
            }
           
            foreach($variations as $key=>$variation){
                // for cloth variation template
                if(!empty($variation['color']) || !empty($variation['size'])){
                    $data = array(
                        'color' => $variation['color'],
                        'size' => $variation['size']
                    );
                    $variation['variation']=json_encode($data);
                }
                
                //$products->stockProduct()->create($variation);
            }
            if(Arr::has($data, 'galleries')){
                foreach($galleries as $key=>$gallery){
                    $products->productGallery()->create($gallery);
                }
            }
        });
    }
}