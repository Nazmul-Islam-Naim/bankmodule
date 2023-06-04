<?php

namespace App\Services;

use App\Contracts\Repositories\AddressRepositoryInterface;
use App\Enum\AddressType;
use App\Exceptions\GeneralException;
use App\Helpers\Helper;
use Exception;
use Illuminate\Support\Arr;

class AddressService extends CoreService
{
    protected $name = "Address";

    public $encryptedId = true;

    public function __construct()
    {

        $this->repository = app()->make(AddressRepositoryInterface::class);
    }


    public function addressStore($parent,$data){
        $this->begin();
        try{
            $parent->addresses()->whereNotIn('type', array_map(fn($address)=>AddressType::getFromName($address['type'])->value,$data['addresses']))->delete();

            $changes = [];

            foreach($data['addresses'] as $address){
                $address['type']= AddressType::getFromName($address['type'])->value;
                $address['addressline']=Arr::pull($address['details'],'addressline');
                $verified = Arr::pull($address,'verified');
                if($add = $parent->addresses()->where('type',$address['type'])->first()){
                    if(! $isEqual =  Helper::isDataSameAsModel($address,$add->toArray())){
                        $add->update(['verified'=>false,...$address]);
                        array_push($changes,AddressType::from($address['type'])->toString());
                    }
                }else{
                    $parent->addresses()->create($address);
                }
            }
            $this->commit();
            return $changes;
        }catch(Exception $exception){
            $this->rollBack();
            throw new GeneralException($exception,'Address store faild');
        }
    }

     /**
     * @param array $update
     * @param int $id
     * @return Bool
     */
    public function addressUpdate($identifier, $parent, $data, $options = [], $callback = null)
    {
        $this->begin();
        try{

        }catch(Exception $exception){

            $this->rollBack();
            throw new GeneralException($exception,'Address update faild');
        }
    }

}
