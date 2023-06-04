<?php

namespace App\Http\Controllers\Api\V1\Vendors;

use App\Authentication\Requests\PhoneLoginRequest;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Vendors\AccountSettingRequest;
use App\Http\Requests\Vendors\AddressSettings;
use App\Http\Requests\Vendors\AddressSettingsRequest;
use App\Http\Requests\Vendors\BusinessInformationSettingsRequest;
use App\Http\Resources\Vendors\BusinessInformationResource;
use App\Http\Resources\Vendors\VendorProfileResource;
use App\Http\Resources\Vendors\VendorResource;
use App\Services\VendorService;

class VendorController extends ApiController
{

    public function __init__()
    {
        $this->service = new VendorService();
    }

    /**
     * shopSetting
     *
     * @param  mixed $request
     * @return void
     */
    public function updateShop(AccountSettingRequest $request){
        try {
            return $this->respond(new VendorResource($this->dispatchService->updateShop($request->all())));
        } catch (\Exception $exception) {
            return $this->exceptionRespond($exception);
        }
    }


    /**
     * getSshop
     *
     * @return void
     */
    public function getShop()
    {
        try {
            $shop =  $this->service->getShop();
            return $this->setMessage('Shop information fatched')->respond(new VendorResource($shop));
        } catch (\Exception $exception) {
            return $this->exceptionRespond($exception);
        }
    }

    public function getBusinessInfo()
    {
        try {
            $businessInfo =  $this->service->getBusinessInfo();
            return $this->setMessage('Business information fatched')->respond($businessInfo?new BusinessInformationResource($businessInfo):null);
        } catch (\Exception $exception) {
            return $this->exceptionRespond($exception);
        }
    }

    public function getAddresses()
    {
        try {
            $addresesses =  $this->service->getAddresses();
            return $this->setMessage('vendor Addressses fatched')->respond($addresesses);
        } catch (\Exception $exception) {
            return $this->exceptionRespond($exception);
        }
    }


    public function updateAddress(AddressSettingsRequest $request){
        try {
            return $this->respond($this->dispatchService->updateAddress($request->all()));
        } catch (\Exception $exception) {
            return $this->exceptionRespond($exception);
        }
    }

    public function updateBusiness(BusinessInformationSettingsRequest $request){
        try {
            return $this->respond($this->dispatchService->updateBusinessInfo($request->all()));
        } catch (\Exception $exception) {
            return $this->exceptionRespond($exception);
        }
    }

}
