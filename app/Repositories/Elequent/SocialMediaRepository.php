<?php

namespace App\Repositories\Elequent;

use App\Contracts\Repositories\SocialMediaRepositoryInterface;
use App\Models\SocialMedia;
use Illuminate\Support\Arr;
class SocialMediaRepository extends BaseRepository  implements SocialMediaRepositoryInterface
{

    public $model = SocialMedia::class;

        /**
     * [Store SocialMedia]
     *
     * @param array $data
     *
     * @return SocialMedia $socialMedia
     *
     */

     public function store($data)
     {
         $model = Parent::store($data);
         
         if (Arr::has($data, 'icon')) {
            $model->icon()->create($data['icon']);
        }
     }

     
    /**
     * [Update SocialMedia]
     *
     * @param array $data
     *
     * @return SocialMedia $socialMedia
     *
     */

     public function update($identifier, $data , $options = [], $callback = null){
        
        $model = Parent::update($identifier, $data , $options);

        if(Arr::has($data,'icon')){
            if($model->icon->path){
                $model->icon->update($data['icon']);
            }
            else{
                $model->icon()->create($data['icon']);
            }
        }
        return $model;
    }


    //filters

    public function search($query, $value = null)
    {
        if ($value) {
            $query->where('title','LIKE','%'.$value.'%')->orWhere('link','LIKE','%'.$value.'%');
        }
    }

}
