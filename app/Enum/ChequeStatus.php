<?php

namespace App\Enum;

use ReflectionEnum;

enum ChequeStatus: int
{
    case Unused      =   1;
    case Used        =   2;
    case Pending     =   3;
    case Bounched    =   4;
    case Canceled    =   5;

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
     * [get case object by value]
     *
     * @return [type]
     *
     */
    public static function getFromValue(int $value){
        foreach (Self::cases() as $case) {
            if ($case->value === $value) {
                return $case;
            }
        }
        
        return null;
    }

    /**
     * [Description for toString]
     *
     * @return [type]
     *
     */
    public function toString(){
        return match($this){
            self::Unused=>"Unused",
            self::Used=>"Used",
            self::Pending=>"Pending",
            self::Bounch=>"Bounch",
            self::Canceled=>"Canceled",
        };
    }


    /**
     * [Description for toString]
     *
     * @return [type]
     *
     */
    public function color(){
        return match($this){
            self::Unused=>"info",
            self::Used=>"success",
            self::Pending=>"warning",
            self::Bounch=>"danger",
            self::Canceled=>"danger",
        };
    }

    /**
     * [Description for toString]
     *
     * @return [type]
     *
     */
    public function getRes(){
        return [
            "color"=>self::color(),
            "string"=>self::toString()
        ];
    }


}
