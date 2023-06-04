<?php

namespace App\Http\Controllers;

use App\Actions\Identifier;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Arr;
use Illuminate\Support\Reflector;
use ReflectionMethod;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

      /**
     * Execute an action on the controller.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function callAction($method, $parameters)
    {

        $this->identifierDitector($method, $parameters);
        return parent::callAction($method, $parameters);
    }


    private function identifierDitector($method,array &$parameters){
        $method_params=(new ReflectionMethod($this, $method))->getParameters();
        foreach($method_params as $key => $param){
            $class_name = Reflector::getParameterClassName($param);
            // dd($param,$class_name, $parameters ,);
            if($class_name && $class_name==Identifier::class){
                $object = Arr::first($parameters, fn ($value) => $value instanceof $class_name);
                if($object){
                    $object->identifier = Arr::pull($parameters,$param->getName());
                }
            }
        }
    }

}
