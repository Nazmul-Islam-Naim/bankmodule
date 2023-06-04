<?php

namespace App\Http\Controllers\Api\V1;

use App\Authentication\Requests\EmailPassLoginRequest;
use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\Admins\AdminProfileResource;
use App\Http\Resources\Admins\AdminResources;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends ApiController
{

    public function __construct()
    {
        $this->service = new AuthService();
    }


    public function adminLogin(EmailPassLoginRequest $request)
    {
        try {
             return  $this->respond($this->service->adminLogin($request->all()));
        } catch (\Exception $exception) {
            return $this->exceptionRespond($exception);
        }
    }

    public function me()
    {
        try {
            $admin =  $this->service->me();
            return $this->setMessage('Auth user fatched')->respond(new AdminProfileResource($admin));
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
