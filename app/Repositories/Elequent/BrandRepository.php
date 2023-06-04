<?php

namespace App\Repositories\Elequent;

use App\Contracts\Repositories\BrandRepositoryInterface;
use App\Models\Brand;
use App\Traits\TranslationRepositoryTrait;
use Illuminate\Support\Arr;

class BrandRepository extends BaseRepository  implements BrandRepositoryInterface
{
    use TranslationRepositoryTrait;

    public $model = Brand::class;

    /**
     * [Store Brand]
     *
     * @param array $data
     *
     * @return Brand $brand
     *
     */

    public function store($data)
    {
        $translations = Arr::pull($data, 'translations');
        return tap(Parent::store($data), function ($model) use ($data, $translations) {
            if ($translations) {
                foreach ($translations as $translation) {
                    $model->translations()->create($translation);
                }
            }

            if (Arr::has($data, 'avatar')) {
                $model->avatar()->create($data['avatar']);
            }
        });
    }


    /**
     * [Update Admins]
     *
     * @param array $data
     *
     * @return Admin $admin
     *
     */
    public function update($identifier, $data , $options = [], $callback = null){
        $translations = Arr::pull($data, 'translations');
        return tap(Parent::update($identifier, $data , $options), function($model) use($data,$translations){

            if($translations){
                $this->deleteTranslation( $model, $translations);
            foreach($translations as $translation){
                $model->translations()->updateOrCreate(['local'=>Arr::pull($translation, 'local')],$translation);
            }
            }

            if(Arr::has($data,'avatar')){
                if($model->avatar->path){
                    $model->avatar->update($data['avatar']);
                }
                else{
                    $model->avatar()->create($data['avatar']);
                }
            }
        });
    }


    //filters

    public function search($query, $value = null)
    {
        if ($value) {
            $query->whereHas('translations',function($query) use($value){
                $query->where('title','LIKE','%'.$value.'%');
            });
        }
    }
}
