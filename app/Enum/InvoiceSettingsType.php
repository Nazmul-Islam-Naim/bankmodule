<?php

namespace App\Enum;

use ReflectionEnum;

enum InvoiceSettingsType: int
{
    case Manually      =   1;
    case Autoincrement =   2;
    case Orderid       =   3;


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
            $arr[$item]=self::getFromName($item)->toDescription();
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
            self::Manually=>"Manually",
            self::Autoincrement=>"Autoincrement",
            self::Orderid=>"Orderid"
        };
    }

    /**
     * description
     *
     * @return void
     */
    public function description(){
        return match($this){
            self::Manually=>"Put invoice number manually while generating invoice",
            self::Autoincrement=>"Invoice number will automatic increment based on your last order",
            self::Orderid=>"Invoice number will set based on orderid"
        };
    }



    /**
     * toDescription
     *
     * @return void
     */
    public function toDescription(){
        return match($this){
            self::Manually=>[
                'title'=>$this->toString(),
                'description'=>$this->toDescription()
            ],
            self::Autoincrement=>[
                'title'=>$this->toString(),
                'description'=>$this->toDescription()
            ],
            self::Orderid=>[
                'title'=>$this->toString(),
                'description'=>$this->toDescription()
            ],
        };
    }



}
