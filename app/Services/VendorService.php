<?php

namespace App\Services;

use App\Actions\DispatchService;
use App\Contracts\Repositories\BusinessInfoRepositoryInterface;
use App\Contracts\Repositories\DeliveryRepositoryInterface;
use App\Contracts\Repositories\VendorRepositoryInterface;
use App\Enum\AddressType;
use App\Enum\BusinessType;
use App\Enum\InvoiceSettingsType;
use App\Enum\Status;
use App\Exceptions\GeneralException;
use App\Helpers\Helper;
use App\Models\Address;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class VendorService extends CoreService
{
    protected $name = "Vendor";

    public $encryptedId = true;

    public function __construct()
    {

        $this->repository = app()->make(VendorRepositoryInterface::class);
    }


    /**
     * [get Status]
     *
     * @param array $data
     *
     * @return Module $modules
     *
     */
    public function getStatus()
    {
        return Status::getCases();
    }


    /**
     * [Store Vendor]
     *
     * @param array $data
     *
     * @return Vendor $vendors
     *
     */
    public function store($data)
    {

        $this->begin();
        try {
            if (Arr::has($data, 'company_logo')) {
                $data['logo'] = $this->upload(Arr::pull($data, 'company_logo'), 'ventors/logo');
            }

            if (Arr::has($data, 'status')) {
                $data['status'] = Status::getFromName(Arr::pull($data, 'status'))->value;
            }

            $data['vendorid'] = $this->generateVendorId();
            $data['password'] = Hash::make(Arr::pull($data, 'password'));
            $model =  Parent::store($data);
            $this->commit();
            return $model;
        } catch (Exception $exception) {
            $this->rollBack();
            throw new GeneralException($exception, "Faild to store vendor");
        }
    }


    /**
     * update
     *
     * @param  mixed $identifier
     * @param  mixed $data
     * @param  mixed $options
     * @param  mixed $callback
     * @return void
     */
    public function update($identifier, $data, $options = [], $callback = null)
    {
        $this->begin();
        try {
            $options['model'] = $this->repository->getModel($identifier, $options, $callback);
            if (Arr::has($data, 'company_logo')) {

                $data['logo'] = $this->cleanAndUpload(Arr::pull($data, 'company_logo'), 'vendors/logo', $options['model']->logo->path);
            }

            if (Arr::has($data, 'status')) {
                $data['status'] = Status::getFromName(Arr::pull($data, 'status'))->value;
            }

            if (Arr::has($data, 'password')) {
                $data['password'] = Hash::make(Arr::pull($data, 'password'));
            }
            $model = Parent::update($identifier, $data, $options, $callback = null);

            $this->commit();
            return $model;
        } catch (Exception $exception) {

            $this->rollBack();
            throw new GeneralException($exception, 'Faild to update vendor');
        }
    }

    /**
     * updateStatus
     *
     * @param  mixed $identifier
     * @param  mixed $data
     * @param  mixed $options
     * @param  mixed $callback
     * @return void
     */
    public function updateStatus($identifier, $data, $options = [], $callback = null)
    {
        $data['status'] = Status::getFromName(Arr::pull($data, 'status'))->value;
        $model = Parent::update($identifier, $data, $options, $callback = null);
        return $model!=null;
    }

    /**
     * shop
     *
     * @return void
     */
    public function getShop($vendor = null)
    {
        $vendor = $this->getVendor($vendor);
        return Parent::show($vendor->id);
    }


    /**
     * getVerifications
     *
     * @param  mixed $vendor
     * @param  mixed $data
     * @return void
     */
    public function getVerifications($vendor=null,$data=[]){

        $vendor         = $this->getVendor($vendor);
        $bankAccount    = $vendor->bankAccount;
        $businessInfo   = $vendor->businessInfo;
        $addresses      = $vendor->addresses;


        $data['businessAddress']    =   false;
        $data['wareHouseAddress']   =   false;
        $data['returnAddress']      =   false;
        $data['businessInfo']       =   false;
        $data['bankAccount']        =   false;

        if($business = $addresses->where('type',AddressType::getFromName('Business')->value)->first()){
            $data['businessAddress'] =(bool)$business->verified;
        }

        if($wareHouse = $addresses->where('type',AddressType::getFromName('Warehouse')->value)->first()){
            $data['wareHouseAddress'] =(bool)$wareHouse->verified;
        }else if($vendor->warehouse){
            $data['wareHouseAddress'] = (bool)$data['businessAddress'];
        }

        if($return = $addresses->where('type',AddressType::getFromName('Returnaddress')->value)->first()){
            $data['returnAddress'] =(bool)$return->verified;
        }else if($vendor->returnaddress){
            $data['returnAddress'] = (bool)$data['businessAddress'];
        }

        if($businessInfo){
            $data['businessInfo'] = (bool)$businessInfo->verified;
        }

        if($bankAccount){
            $data['bankAccount'] = (bool)$bankAccount->verified;
        }

        return $data;

    }



    /**
     * getDeliveries
     *
     * @return void
     */
    public function getDeliveries($vendor)
    {
        $vendor = $this->getVendor($vendor);
        $deliveries  = Service::delivery()->index(['filters'=>['active']]);

        $deliveries->map(function($delivery) use($vendor){
            $delivery->status = (bool)$vendor->deliveries->where('id',$delivery->id)->first();
        });

        return $deliveries;
    }


    /**
     * getInvoiceSettingTypes
     *
     * @return void
     */
    public function getInvoiceSettingTypes()
    {
        return InvoiceSettingsType::get();
    }


    /**
     * addresses
     *
     * @return void
     */
    public function getAddresses($vendor=null)
    {
        $vendor = $this->getVendor($vendor);
        return [
            'warehouse' => (bool)$vendor->warehouse,
            'returnaddress' => (bool)$vendor->returnaddress,
            'addresses' => LocationService::instance()->formater($vendor->addresses)
        ];
    }


    /**
     * getBusinessInfo
     *
     * @return void
     */
    public function getBusinessInfo($vendor=null)
    {
        $vendor = $this->getVendor($vendor);
        return $vendor->businessInfo;
    }

    /**
     * updateShop
     *
     * @return void
     */
    public function updateShop($data)
    {
        $vendor = Auth::user();
        return $this->update($vendor->id, $data);
    }

    /**
     * updateAddress
     *
     * @param  mixed $data
     * @return void
     */
    public function updateAddress($data)
    {

        LocationService::instance()->requestValidate($data['addresses']);
        $vendor = Auth::user();

        $basic['warehouse'] = Arr::pull($data, 'warehouse') == 'true';
        $basic['returnaddress'] = Arr::pull($data, 'returnaddress') == 'true';

        parent::update($vendor->id, $basic);
        $changes = Service::address()->addressStore($vendor, $data);
        logger()->error($changes);
    }

    /**
     * updateVerifications
     *
     * @param  mixed $vendor
     * @param  mixed $data
     * @return void
     */
    public function updateVerifications($vendor=null, $data)
    {
        $vendor         = $this->getVendor($vendor);
        $bankAccount    = $vendor->bankAccount;
        $businessInfo   = $vendor->businessInfo;
        $addresses      = $vendor->addresses;

        $data['setting'] = filter_var($data['setting'], FILTER_VALIDATE_BOOLEAN);

        if($data['type'] == 'businessAddress'){
            if($business = $addresses->where('type',AddressType::getFromName('Business')->value)->first()){
                $business->update([
                    'verified'=> boolval($data['setting'])
                ]);
            }
        }

        if($data['type'] == 'wareHouseAddress'){
            if($wareHouse = $addresses->where('type',AddressType::getFromName('Warehouse')->value)->first()){
                $wareHouse->update([
                    'verified'=>boolval($data['setting'])
                ]);
            }
        }

        if($data['type'] == 'returnAddress'){
            if($return = $addresses->where('type',AddressType::getFromName('Returnaddress')->value)->first()){
                $return->update([
                    'verified'=>boolval($data['setting'])
                ]);
            }
        }

        if($data['type'] == 'businessInfo'){
            if($businessInfo){
                $businessInfo->update([
                    'verified'=>boolval($data['setting'])
                ]);
            }
        }

        if($data['type'] == 'bankAccount'){
            if($bankAccount){
                $bankAccount->update([
                    'verified'=>boolval($data['setting'])
                ]);
            }
        }
    }

    public function assignDeliveryMethods($vendor=null, $data)
    {
        $vendor = $this->getVendor($vendor);
        $data['id']     =   Helper::decrypt($data['id']);
        $data['status'] =   boolval(filter_var($data['status'], FILTER_VALIDATE_BOOLEAN));

        return $this->repository->assignDeliveryMethods($vendor, $data);
    }


    /**
     * updateBusinessInfo
     *
     * @param  mixed $data
     * @return void
     */
    public function updateBusinessInfo($data)
    {
        $this->begin();
        try {
            $vendor = Auth::user();
            $changes = Service::businessInfo()->updateBusinessInfo($vendor, ['type' => Arr::pull($data, 'type'), ...Arr::pull($data, 'field')]);
            array_push($changes, ...(new DispatchService(Service::bankAccount()))->updateBankAccount($vendor, $data));
            logger()->error($changes);
            $this->commit();
        } catch (Exception $exception) {
            $this->rollBack();
            throw new Exception($exception->getMessage());
        }
    }


    /**
     * generateVendorId
     *
     * @return void
     */
    private function generateVendorId()
    {
        return rand(9, 9999);
    }


    /**
     * getVendor
     *
     * @param  mixed $vendor
     */
    public function getVendor($vendor = null){
        if($vendor){
            return $this->repository->getModel($vendor);
        }
        return Auth::User();
    }
}
