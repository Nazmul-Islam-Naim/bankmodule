<?php

namespace App\Repositories\Elequent;

use App\Contracts\Repositories\LogoRepositoryInterface;
use App\Models\Logo;
use Illuminate\Support\Arr;
class LogoRepository extends BaseRepository  implements LogoRepositoryInterface
{

    public $model = Logo::class;

        /**
     * [Store Logo]
     *
     * @param array $data
     *
     * @return Logo $logo
     *
     */

     public function store($data)
     {
         $model = Parent::store($data);
         
        if (Arr::has($data, 'fav_icon')) {
            $model->logo()->create(['tag' => 'fav_icon', ...$data['fav_icon']]);
        }

        if (Arr::has($data, 'header_logo')) {
            $model->logo()->create(['tag' => 'header_logo', ...$data['header_logo']]);
        }

        if (Arr::has($data, 'footer_logo')) {
            $model->logo()->create(['tag' => 'footer_logo', ...$data['footer_logo']]);
        }
     }

     
    /**
     * [Update Logo]
     *
     * @param array $data
     *
     * @return Logo $logo
     *
     */

     public function update($identifier, $data , $options = [], $callback = null){
        
        $model = Parent::update($identifier, $data , $options);

        if(Arr::has($data,'fav_icon')){
            if($model->logo->path){
                $model->logo->update(['tag' => 'fav_icon', ...$data['fav_icon']]);
            }
            else{
                $model->logo()->create(['tag' => 'fav_icon', ...$data['fav_icon']]);
            }
        }

        if(Arr::has($data,'header_logo')){
            if($model->logo->path){
                $model->logo->update(['tag' => 'header_logo', ...$data['header_logo']]);
            }
            else{
                $model->logo()->create(['tag' => 'header_logo', ...$data['header_logo']]);
            }
        }

        if(Arr::has($data,'footer_logo')){
            if($model->logo->path){
                $model->logo->update(['tag' => 'footer_logo', ...$data['footer_logo']]);
            }
            else{
                $model->logo()->create(['tag' => 'footer_logo', ...$data['footer_logo']]);
            }
        }
        return $model;
    }


    //filters

    public function search($query, $value = null)
    {
        if ($value) {
            $query->where('title','LIKE','%'.$value.'%');
        }
    }

}
