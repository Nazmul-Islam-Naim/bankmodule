<?php

namespace App\Rules;

use App\Services\LanguageService;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Arr;

class TraslationRule implements Rule
{
    private $message;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if($keys=array_diff(array_keys($value),array_keys(LanguageService::instance()->getAvailableLanguagesCode()))){
            foreach($keys as $key){
                $this->message = $key .' is not allowed';
                return false;
            }
        }

        if(! Arr::exists($value,LanguageService::instance()->default)){
            $this->message = LanguageService::instance()->default.' required';
            return false ;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->message;
    }
}
