<?php

namespace App\Helpers;

use App\Models\Admin;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\TranslatableTrait;
use Illuminate\Support\Facades\Crypt;
use ReflectionClass;
use ReflectionException;

class Helper
{
     /**
     * @param $class
     * @return string
     */
    public static function getResourceName($class): string
    {
        $reflectionClass = new ReflectionClass($class);
        return $reflectionClass->getName();
    }

    /**
     * @param $request
     * @param $key
     * @return bool
     */
    public static function checkIfNotNull($request, $key): bool
    {
        return (Arr::has($request, $key) && !is_null(Arr::get($request, $key)));
    }

    /**
     * @param $request
     * @param $key
     * @return bool
     */
    public static function checkIfTrue($request, $key): bool
    {
        return (Arr::has($request, $key) && (bool)Arr::get($request, $key) === true);
    }


    /**
     * [Description for hidenotifable]
     *
     * @param mixed $mailer
     *
     * @return [type]
     *
     */
    public static function hidenotifable($mailer){
        return substr($mailer, 0, 4) . "****" . substr($mailer, 7, 4);
    }


    /**
     * [Description for authorize]
     *
     * @param mixed $authorize
     *
     * @return [type]
     *
     */
    public static function authorized($authorize){
        if($authorize == 'vendor'){

        }
        // return Auth::user()->tokenCan($authorize);
        return true;
    }


    /**
     * [Description for defaultErrorMessage]
     *
     *
     * @return [String]
     *
     */
    public static function defaultErrorMessage(){
        return "Something went wrong ";
    }

    /**
     * [Description for hasSoftdelete]
     *
     *
     * @return [String]
     *
     */
    public static function hasSoftDelete($model){
        return in_array(SoftDeletes::class, class_uses_recursive($model));
    }

    /**
     * [Description for hasTranslation]
     *
     *
     * @return [String]
     *
     */
    public static function hasTranslation($model){
        return in_array(TranslatableTrait::class, class_uses_recursive($model));
    }

    /**
     * [Description for decrypt]
     *
     *
     * @return [String]
     *
     */
    public static function decrypt($item){
        return  Crypt::decryptString($item);
    }

    /**
     * encrypt
     *
     * @param  mixed $item
     * @return void
     */
    public static function encrypt($item){
        return  Crypt::encryptString($item);
    }


    /**
     * isDataSameAsModel
     *
     * @param  mixed $data
     * @param  mixed $model
     * @return void
     */
    public static function isDataSameAsModel($data, $model){

        foreach ($data as $key => $value) {
            if (!array_key_exists($key, $model)) {
                return false;
            }

            if (is_array($value) && is_array($model[$key])) {
                if (!self::isDataSameAsModel($value, $model[$key])) {
                    return false;
                }
            } elseif ($value !== $model[$key]) {
                return false;
            }
        }

        return true;
    }

}
