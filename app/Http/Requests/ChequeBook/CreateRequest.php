<?php

namespace App\Http\Requests\ChequeBook;

use App\Helpers\Helper;
use App\Models\ChequeBook;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Helper::authorized('app.chequeBook.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'bank_id' => ['required'],
            'title' => ['required', 'max:50'],
            'book_number' => ['required', Rule::unique(ChequeBook::class)],
            'pages' => ['required', 'numeric']
        ];
    }
}
