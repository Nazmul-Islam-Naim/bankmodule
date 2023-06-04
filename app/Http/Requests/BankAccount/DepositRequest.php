<?php

namespace App\Http\Requests\BankAccount;

use App\Helpers\Helper;
use Illuminate\Foundation\Http\FormRequest;

class DepositRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Helper::authorized('app.bankAccount.deposit');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'amount' => ['required', 'numeric'],
            'transaction_date' => ['required', 'date_format:Y-m-d'],
            'transaction_note' => ['nullable', 'max:255']
        ];
    }
}
