<?php

namespace App\Traits;

use App\Enum\Message;
use App\Log\Services\LogService;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

/**
 * 
 */
trait Logable
{
    /**
     * [Description for userAction]
     *
     * @param mixed $message
     * 
     * @return [type]
     * 
     */
    protected function userAction($type,$message = null,$properties=[]){
        $user=Auth::user();
        if(! $message && $enum = Message::tryFrom($this->serviceType)){
            $message =  $this->getName($enum).' '.$enum->description()['logMessage'];
        }
      
        $log=new LogService();
        $log->set([
            'type'=>$type,
            'template'=>'userAction',
            'message'=> $message.' by '.(app()->runningInConsole()?"console":($user?$user->id:'anonymous')),
            'model'=>app()->runningInConsole()?"console":($user?get_class($user):null),
            'causer_by'=>app()->runningInConsole()?"console":($user?$user->id:null),
            'properties'=>$properties
        ]);
       
        return $this;
    }

    /**
     * [Description for loginAction]
     *
     * @param mixed $message
     * @param mixed $status
     * @param mixed $username
     * 
     * @return [type]
     * 
     */
    protected function loginAction($message,$status,$username){
        $log=new LogService();
        $log->set([
            'type'=>"Login",
            'template'=>'loginAction',
            'ip'=>"",
            'agent'=>"",
            'message'=>$message,
            'status'=>$status,
            'username'=>$username,
        ]);
       
        return $this;
    }

    
    /**
     * generateLog
     *
     * @return void
     */
    protected function logListener(){
        if(is_array($this->logConfig) && Arr::has($this->logConfig, $this->serviceType)){
            if(Arr::has($this->logConfig,$this->serviceType.'.actions') && is_array( $actions = Arr::get($this->logConfig, $this->serviceType.'.actions'))){
                foreach($actions as $action){
                    $this->$action($this->serviceType, null ,$this->serviceData);
                }
            }
        }
    }
}