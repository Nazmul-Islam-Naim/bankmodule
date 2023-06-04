<?php

namespace App\Actions;

use Illuminate\Support\Arr;
use ReflectionMethod;
use Illuminate\Support\Reflector;

class DispatchService 
{
  protected $service;

  public function __construct($service)
  {
    $this->service=$service;
  }

  
  /**
   * __call
   *
   * @param  mixed $method
   * @param  mixed $arguments
   * @return void
   */
  public function __call($method, $arguments){
    $method_params=(new ReflectionMethod($this->service, $method))->getParameters();

    foreach($this->service->dispatchRules as $rule){
        $arg = Arr::first($method_params, fn ($value) => $value->getName() == $rule );
        $rulemethod = $rule.'Rules';
        $arguments[$arg->getPosition()] = $this->service->$rulemethod($arguments[ $arg->getPosition()]);
    }

    return $this->service->$method(...$arguments);
  }
  
}