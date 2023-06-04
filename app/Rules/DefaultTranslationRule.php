<?php

namespace App\Rules;

use App\Services\LanguageService;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Arr;

class DefaultTranslationRule implements Rule
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
        return Arr::exists($value,LanguageService::instance()->default);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Default language '.LanguageService::instance()->default.' missing';
    }
}
