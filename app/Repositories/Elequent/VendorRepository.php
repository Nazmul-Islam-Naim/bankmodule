<?php

namespace App\Repositories\Elequent;

use App\Contracts\Repositories\VendorRepositoryInterface;
use App\Helpers\Helper;
use App\Models\Vendor;
use App\Traits\TranslationRepositoryTrait;
use Illuminate\Support\Arr;

class VendorRepository extends BaseRepository  implements VendorRepositoryInterface
{
    use TranslationRepositoryTrait;

    public $model = Vendor::class;


    /**
     * register
     *
     * @param  mixed $data
     * @return void
     */
    public function registration($data){
        return Parent::store($data);
    }

    /**
     * [Store Admins]
     *
     * @param array $data
     *
     * @return Admin $admin
     *
     */
    public function store($data){
        $translations = Arr::pull($data, 'translations');
        return tap(Parent::store($data), function($model) use($data,$translations){
            if($translations){
                foreach($translations as $translation){
                    $model->translations()->create($translation);
                }
            }

            if(Arr::has($data,'logo')){
                $model->logo()->create($data['logo']);
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

            if(Arr::has($data,'logo')){
                if($model->logo->path){
                    $model->logo->update($data['logo']);
                }
                else{
                    $model->logo()->create($data['logo']);
                }
            }
        });
    }



    public function updateAddress($vendor,$data){

        $basic['warehouse'] = Arr::pull($data,'warehouse')=='true';
        $basic['returnaddress'] = Arr::pull($data,'returnaddress')=='true';
        tap(Parent::update($vendor->id,$basic),function($vendor) use($data){

            $vendor->addresses()->whereNotIn('type', array_map(fn($address)=>$address['type'],$data['addresses']))->delete();

            foreach($data['addresses'] as $address){

                if($add = $vendor->addresses()->where('type',$address['type'])->first()){
                    if(! $isEqual =  Helper::isDataSameAsModel($address,$add->toArray())){
                        $add->update(['verified'=>false,...$address]);
                    }
                }else{

                    $vendor->addresses()->create($address);
                }
            }

        });
    }


    public function assignDeliveryMethods($vendor,$data){
        if($data['status']){
            return $vendor->deliveries()->attach($data['id']);
        }else{
            return $vendor->deliveries()->detach($data['id']);
        }
    }

}
