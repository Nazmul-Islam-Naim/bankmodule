<?php

namespace App\Actions\Locations;

class Location{

    /**
     * [Description for __callStatic]
     *
     * @param mixed $name
     * @param mixed $arguments
     *
     * @return [type]
     *
     */
    public static function get($name, $arguments=[])
    {
        $location= "App\\Actions\\Locations\\".$name;
        if(class_exists($location)){
            return new $location(...$arguments);
        }
    }

}
