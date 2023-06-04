<?php

namespace App\Http\Controllers\Api;

use App\Traits\ApiResponses;
use App\Traits\BaseController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    use ApiResponses, BaseController;

    /**
     * Service class
     */
    protected $service;


    public function destroy($identifier, $filters=[])
    {
        try {
            return $this->authorized("destroy")
            ->setMessage()
            ->respondWithSuccess($this->service->destroy($this->setIdentifier($identifier)));
        }

        catch ( \Exception $exception) {
            return $this->exceptionRespond($exception);
        }
    }


    public function destroyMultiple(Request $request) {

        try {
            return $this->authorized("destroy")
            ->setMessage()
            ->respondWithSuccess( $this->service->destroyMultiple($request->all()));
        }

        catch ( \Exception $exception) {
            return $this->exceptionRespond($exception);
        }
    }


   public function forceDelete($identifier){
    return $this->authorized("destroy")
    ->setMessage()
    ->respondWithSuccess($this->service->forceDelete($this->setIdentifier($identifier)));
        try {

        }

        catch ( \Exception $exception) {
            return $this->exceptionRespond($exception);
        }
    }


    public function restore($identifier){
        try {
            return $this->authorized("destroy")
            ->setMessage()
            ->respondWithSuccess($this->service->restore($this->setIdentifier($identifier)));
        }

        catch ( \Exception $exception) {
            return $this->exceptionRespond($exception);
        }
    }


    public function restoreAll(Request $request){

        try {
            return $this->authorized("destroy")
            ->setMessage()
            ->respondWithSuccess( $this->service->restoreAll());
        }

        catch ( \Exception $exception) {
            return $this->exceptionRespond($exception);
        }
    }


    public function emptyTrash(Request $request){
        try {
            return $this->authorized("destroy")
            ->setMessage()
            ->respondWithSuccess($this->service->emptyTrash());
        } catch ( \Exception $exception) {
            return $this->exceptionRespond($exception);
        }
    }
}
