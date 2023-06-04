<?php

namespace App\Http\Requests\Roles;

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
        return Helper::authorized("app.roles.update");
    }

    public function dycryptedid(){
        return Helper::decrypt($this->role);
    } 

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title'         => ["required",Rule::unique('roles')->ignore($this->dycryptedid())],
            'permissions'   => "required|array"
        ];
    }
}
