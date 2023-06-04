<?php

namespace App\Rules;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;

use Illuminate\Contracts\Validation\Rule;

class BusinessInfoImageRule implements Rule
{
    protected $vendor;
    protected $type;
    protected $required;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($vendor, $type, $required)
    {
        $this->vendor = $vendor;
        $this->type = $type;
        $this->required = $required;
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
            $field = str_replace('field.','',$attribute);
            $business =  $this->vendor->businessInfo;

            if($business &&  $business->$field->path){
                // logger()->error([$business->$field->path,'sdfsdf',$business &&  $business->$field->path]);
                return true;
            }else{
                // logger()->error([
                //     $this->type,$this->required,'sdfsdf'
                // ]);
                return $this->type!=$this->required;
            }
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
