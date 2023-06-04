<?php

namespace App\Services;

class Service{

    /**
     * [Description for __callStatic]
     *
     * @param mixed $name
     * @param mixed $arguments
     *
     * @return [type]
     *
     */
    public static function __callStatic($name, $arguments)
    {
        $service= "App\\Services\\".ucfirst($name)."Service";
        if(class_exists($service)){
            return new $service(...$arguments);
        }
    }

}
