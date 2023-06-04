<?php

namespace App\Http\Requests\Tests;

use Illuminate\Foundation\Http\FormRequest;
use App\Helpers\Helper;
use App\Rules\TranslationRule;

class UpdateReqest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Helper::authorized("app.tests.create");
    }

     /**
     * This will return original id if id encrypted
     *
     * @return bool
     */
    //public function dycryptedid(){
    //    return Helper::decrypt($this->test);
    //}

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [

        ];
    }
}
