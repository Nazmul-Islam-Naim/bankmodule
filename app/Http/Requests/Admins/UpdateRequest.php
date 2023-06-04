<?php

namespace App\Http\Requests\Admins;

use App\Helpers\Helper;
use App\Rules\DefaultTranslationRule;
use App\Rules\TranslationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Helper::authorized("app.admins.update");
    }

    /**
     * This will return original id if id encrypted
     *
     * @return bool
     */
    public function dycryptedid()
    {
        return Helper::decrypt($this->admin);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'phone'    => ["required", Rule::unique("admins")->ignore($this->dycryptedid())],
            'email'    => ["required", "email", Rule::unique("admins")->ignore($this->dycryptedid())],
            'password' => 'nullable|confirmed|min:8',
            'role_id'  => 'required',
            'avatar'   => 'sometimes|image',

            'translations'            =>  ['required', 'array', new TranslationRule()],
            'translations.*.firstname' =>  'required|string|max:20',
            'translations.*.lastname' =>  'required|string|max:20'
        ];
    }
}
