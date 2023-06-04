<?php

namespace App\Repositories\Elequent;

use App\Contracts\Repositories\SliderRepositoryInterface;
use App\Models\Slider;
use Illuminate\Support\Arr;
class SliderRepository extends BaseRepository  implements SliderRepositoryInterface
{

    public $model = Slider::class;

        /**
     * [Store Slider]
     *
     * @param array $data
     *
     * @return Slider $slider
     *
     */

     public function store($data)
     {
         $model = Parent::store($data);
         
         if (Arr::has($data, 'slider_image')) {
            $model->sliderImage()->create($data['slider_image']);
        }
     }

     
    /**
     * [Update Slider]
     *
     * @param array $data
     *
     * @return Slider $slider
     *
     */

     public function update($identifier, $data , $options = [], $callback = null){

        $model = Parent::update($identifier, $data , $options);

        if(Arr::has($data,'slider_image')){
            if($model->sliderImage->path){
                $model->sliderImage->update($data['slider_image']);
            }
            else{
                $model->sliderImage()->create($data['slider_image']);
            }
        }
        return $model;
    }


    //filters

    public function search($query, $value = null)
    {
        if ($value) {
            $query->where('title','LIKE','%'.$value.'%')->orWhere('url','LIKE','%'.$value.'%');
        }
    }

}
