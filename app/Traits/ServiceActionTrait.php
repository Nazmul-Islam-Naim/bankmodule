<?php

namespace App\Traits;

use Illuminate\Support\Arr;

trait ServiceActionTrait
{

    protected $serviceType = '';

    protected $serviceModel = null;

    protected $serviceData  = [];

    protected $serviceProperties = [];

    protected $listeners = [];

    protected function getType($type){
        if(!$type){
            return $this->getMethodName(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 3)[2]['function']);
        }
        return $type;
    }

    protected function setServiceValues(array $options=[]){
        
        $this->serviceType = $this->getType(Arr::has($options, 'type')?$options['type']:null);

        if(Arr::has($options, 'model')){
            $this->serviceModel = $options['model'];
        }
        if(Arr::has($options, 'data')){
            $this->serviceData = $options['data'];
        }
        if(Arr::has($options, 'properties')){
            $this->serviceProperties = $options['properties'];
        }

        return $this;
    }


    protected function serviceEvent(){
        foreach($this->listeners as $listener){
            $this->$listener();
        }
    }    
}