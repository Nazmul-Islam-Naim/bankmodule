<?php

namespace App\Http\Requests\Admins;

use App\Enum\Type;
use App\Helpers\Helper;
use App\Rules\DefaultTranslationRule;
use App\Rules\RoleTitleUniqueRule;
use App\Rules\TranslationRule;
use App\Services\LanguageService;
use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Helper::authorized("app.admins.create");
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'phone'    => "required|unique:admins",
            'email'    => "required|email|unique:admins",
            'password' => 'required|confirmed|min:8',
            'role_id'  => 'required',
            'avatar'   => 'sometimes|image',

            'translations'            =>  ['required', 'array', new TranslationRule()],
            'translations.*.firstname' =>  'required|string|max:20',
            'translations.*.lastname' =>  'required|string|max:20'
        ];
    }
}
