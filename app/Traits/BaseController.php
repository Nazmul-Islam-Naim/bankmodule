<?php

namespace App\Traits;

use App\Actions\DispatchService;
use App\Enum\Message;
use App\Helpers\Helper;
use Illuminate\Support\Str;

trait BaseController
{
    protected $dispatchService;

    protected $name;


    public function __construct()
    {
        $this->__init__();
        $this->dispatchService = new DispatchService($this->service);
        // $this->name            = ;
    }


   /**
     * Authorize user before  performing controller Action
     *
     * @param [string] $authorize
     * @throws UnathorizedException
     * @return Object
     */
    public function authorized($authorize, $default = true){
        $default? $authorize = "app.".Str::plural($this->name).".".$authorize:null;
        Helper::authorized($authorize);
        return $this;
    }

    /**
     * @param $message
     * @return $this
     */
    public function setMessage($message = null): self
    {
        if($message){
            $this->message = $message;
        }

        else{
            $method = $this->service->getMethodName(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2)[1]['function']);
            if($enum = Message::tryFrom($method)){
                $this->message =  $this->service->getName($enum).' '.$enum->description()['message'];
            }
        }
        return $this;
    }


    /**
    *
    * @param array $identifier
    * @return identifier
    */
    public function setIdentifier($identifier){
        if($this->service->encryptedId){
            return Helper::decrypt($identifier);
        }
       return $identifier;
    }

}
