<?php

namespace App\Http\Requests\SocialMedia;

use App\Helpers\Helper;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Helper::authorized('app.socialMedia.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => ['required', 'max:50'],
            'link' => ['required', 'url', 'max:255'],
            'icon' => ['nullable', 'mimes:png,svg']
        ];
    }
}
