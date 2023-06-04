<?php

namespace App\Http\Requests\Sliders;

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
        return Helper::authorized('app.sliders.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => ['required','string','max:50'],
            'url' => ['nullable','url'],
            'background_color' => ['required','max:20'],
            'slider_image' => ['required','image'],
        ];
    }
}
