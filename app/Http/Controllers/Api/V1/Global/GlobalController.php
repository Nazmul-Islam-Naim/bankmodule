<?php

namespace App\Http\Controllers\Api\V1\Global;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Globals\OtpRequest;
use App\Http\Resources\Banks\BankResources;
use App\Http\Resources\Deliveries\DeliveryRsources;
use App\Http\Resources\Globals\CountryResources;
use App\Services\Service;
use Illuminate\Http\Request;

class GlobalController extends ApiController
{
    public function __construct()
    {
     //
    }


    public function languages()
    {
        try {
             return $this->setMessage('Available Lenguage fetched')->respond(Service::language()->getAvailableLanguages());
        } catch (\Exception $exception) {
            return $this->exceptionRespond($exception);
        }
    }

    public function getImage($title)
    {
        try {
             return $this->setMessage($title.' image fetched')->respond(Service::ExampleImage()->get($title));
        } catch (\Exception $exception) {
            return $this->exceptionRespond($exception);
        }
    }

    public function generateOtp(OtpRequest $request)
    {
        try {
             return $this->setMessage('otp Generated')->respond(Service::Global()->generateOtp($request->all()));
        } catch (\Exception $exception) {
            return $this->exceptionRespond($exception);
        }
    }

    public function getCountries()
    {
        try {
             return $this->setMessage('Countries fetched')->respond(CountryResources::collection(collect(array_map(function ($item) {
                return (object) $item;
            }, Service::Location()->getAvailableCountries()->toArray()))));
        } catch (\Exception $exception) {
            return $this->exceptionRespond($exception);
        }
    }

    public function getLocations(Request $request)
    {
        try {
             return $this->setMessage('Location fetched')->respond(Service::Location()->getLocations($request->query->all()));
        } catch (\Exception $exception) {
            return $this->exceptionRespond($exception);
        }
    }

    public function getbanks(Request $request)
    {
        try {
             return $this->setMessage('Bank fetched')->respond(BankResources::collection(Service::bank()->index(['filters'=>['active']])));
        } catch (\Exception $exception) {
            return $this->exceptionRespond($exception);
        }
    }

    public function getAdminStatus(Request $request)
    {
        try {
             return $this->setMessage('Fetched bank status')->respond(Service::admin()->getStatus());
        } catch (\Exception $exception) {
            return $this->exceptionRespond($exception);
        }
    }

    public function getVendorStatus(Request $request)
    {
        try {
             return $this->setMessage('Fetched bank status')->respond(Service::vendor()->getStatus());
        } catch (\Exception $exception) {
            return $this->exceptionRespond($exception);
        }
    }

    public function getInvoiceSettingsType(Request $request)
    {
        try {
             return $this->setMessage('Type fetched')->respond(Service::vendor()->getInvoiceSettingTypes());
        } catch (\Exception $exception) {
            return $this->exceptionRespond($exception);
        }
    }
}
