<?php

namespace App\Repositories\Elequent;

use App\Contracts\Repositories\CategoryRipositoryInterface;
use App\Models\Category;
use App\Traits\TranslationRepositoryTrait;
use Illuminate\Support\Arr;

class CategoryRipository extends BaseRepository  implements CategoryRipositoryInterface
{
    use TranslationRepositoryTrait;

    public $model = Category::class;

    /**
     * [Store Category]
     *
     * @param array $data
     *
     * @return Category $categories
     *
     */
    public function store($data){
        $translations = Arr::pull($data, 'translations');
        $brands = Arr::pull($data, 'brands');
        $properties = Arr::pull($data, 'properties');
        return tap(Parent::store($data), function($categories) use($translations,$brands,$properties){
            $categories->brands()->attach($brands);
            $categories->property()->attach($properties);
            foreach($translations as $key=>$translation){
                $categories->translations()->create($translation);
            }
        });
    }
}