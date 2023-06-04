<?php

namespace App\Http\Requests\Logo;

use App\Helpers\Helper;
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
        return Helper::authorized('app.logo.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => ['required', 'string', 'max:50'],
            'fav_icon' => ['required', 'image', 'mimes:svg,png'],
            'header_logo' => ['required', 'image', 'mimes:svg,png'],
            'footer_logo' => ['required', 'image', 'mimes:svg,png'],
        ];
    }
}
