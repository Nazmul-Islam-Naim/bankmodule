<?php

namespace App\Rules;

use App\Services\LanguageService;
use Illuminate\Contracts\Validation\Rule;

class AvailableTranslationRule implements Rule
{
    private $language; 
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
                $this->language = $key;
                return false;
            }
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return  $this->language.' are not allowed ';
    }
}
