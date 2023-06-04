<?php

namespace App\Http\Controllers\Api\V1\Global;

use App\Authentication\Requests\PhoneLoginRequest;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Registrations\CustomerRegistrationRequest;
use App\Http\Requests\Registrations\VendorRegistrationRequest;
use App\Http\Resources\Customers\CustomerProfileResource;
use App\Http\Resources\Vendors\VendorProfileResource;
use App\Services\AuthService;
use App\Services\RegistrationService;
use App\Services\Service;

class AuthController extends ApiController
{

    public function __construct()
    {
        $this->service = new AuthService();
    }

    public function registration(CustomerRegistrationRequest $request){
        try {
            return $this->respond(Service::registration()->customerRegistration($request->all()));
        } catch (\Exception $exception) {
            return $this->exceptionRespond($exception);
        }
    }


    public function login(PhoneLoginRequest $request)
    {
        try {
            return $this->respond($this->service->customerLogin($request->all()));
        } catch (\Exception $exception) {
            return $this->exceptionRespond($exception);
        }
    }

    public function me()
    {
        try {
            $user =  $this->service->me();
            return $this->setMessage('Auth user fatched')->respond(new CustomerProfileResource($user));
        } catch (\Exception $exception) {
            return $this->exceptionRespond($exception);
        }
    }

    public function logout()
    {
        try {
            return $this->setMessage('logout Successfull')->respond($this->service->logout());
        } catch (\Exception $exception) {
            return $this->exceptionRespond($exception);
        }
    }
}
