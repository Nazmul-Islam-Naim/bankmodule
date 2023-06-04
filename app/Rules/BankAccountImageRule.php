<?php

namespace App\Rules;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;

use Illuminate\Contracts\Validation\Rule;

class BankAccountImageRule implements Rule
{
    protected $vendor;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($vendor)
    {
        $this->vendor = $vendor;
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
        if(!$value){
            $bankAccount =  $this->vendor->bankAccount;

            return $bankAccount &&  $bankAccount->bankDocument->path;
        }


        if (!$value instanceof UploadedFile || !$value->isValid()) {
            return false;
        }

        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

        $extension = strtolower($value->getClientOriginalExtension());

        return in_array($extension, $allowedExtensions) && File::isFile($value->getPathname());

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be a valid image file.';
    }
}
