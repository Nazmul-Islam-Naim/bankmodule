<?php

namespace App\Authentication\Requests;

use App\Helpers\Helper;
use Illuminate\Foundation\Http\FormRequest;

class EmailPassLoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // return Helper::authorized("app.flows.create");
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email'     => "required|email",
            'password'  => "required"
        ];
    }
}
