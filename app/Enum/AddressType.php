<?php

namespace App\Enum;

use ReflectionEnum;

enum AddressType: int
{
    case Primary        =   1;
    case Secondary      =   2;
    case Warehouse      =   3;
    case Returnaddress  =   4;
    case Business       =   5;

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
            self::Primary=>"Primary",
            self::Business=>"Business",
            self::Secondary=>"Secondary",
            self::Warehouse=>"Warehouse",
            self::Returnaddress=>"Returnaddress"
        };
    }


}
