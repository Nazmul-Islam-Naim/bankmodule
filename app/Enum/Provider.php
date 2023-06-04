<?php

namespace App\Enum;

use ReflectionEnum;

enum Provider: int
{
    case public     =    1;
    case local      =    2;
    case s3         =    3;

    /**
     * [Will return cases name list]
     *
     * @return [array]
     *
     */
    public static function getCases(){
        return array_column(self::cases(), 'name');
    }

   /**
     * [return cases list with description]
     *
     * @return [array]
     *
     */
    public static function get(){
        foreach(array_column(self::cases(), 'name') as $item){
            $arr[$item]=self::getFromName($item)->toString();
        }
        return $arr;
    }

     /**
     * [get case object by name]
     *
     * @return [type]
     *
     */
    public static function getFromName($name){
        $reflection = new ReflectionEnum(self::class);
        return $reflection->getCase($name)->getValue();
    }

    /**
     * [Description for toString]
     *
     * @return [type]
     *
     */
    public function toString(){
        return match($this){
            self::public=>"Public",
            self::local=>"Local",
            self::s3=>"S3",
        };
    }


}
