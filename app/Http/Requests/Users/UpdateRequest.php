<?php

namespace App\Http\Requests\Users;

use App\Enum\Type;
use App\Helpers\Helper;
use App\Rules\RoleTitleUniqueRule;
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
        return Helper::authorized("app.users.update");
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name'    => "required|unique:users",
            'role_id' => ["required",Rule::unique('users')->ignore($this->user)],
            'email'   => 'required|email',
            'avatar'  => 'sometimes|image'
        ];
    }
}
