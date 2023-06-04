<?php

namespace App\Rules;

use App\Services\LanguageService;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class TranslationRule implements Rule
{
    private $language;
    private $message;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->language = LanguageService::instance();
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
        if($keys=array_diff(array_map(fn($item)=>$item['local'],$value),$this->language->getAvailableLanguagesCode())){
            foreach($keys as $key){
                $this->message = $key .' is not allowed';
                return false;
            }
        }

        if(! in_array($this->language->default,array_map(fn($item)=>$item['local'],$value))){
            $this->message = $this->language->default.' required';
            return false ;
        }

        return true;
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
