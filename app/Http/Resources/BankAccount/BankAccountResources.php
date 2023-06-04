<?php

namespace App\Http\Resources\BankAccount;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Crypt;

class BankAccountResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => Crypt::encryptString($this->id),
            'bank_id' =>  Crypt::encryptString($this->bank->id),
            'bank_title' => $this->bank->title,
            'bank_slug' => $this->bank->slug,
            'accoutn_type_id' =>  Crypt::encryptString($this->accountType->id),
            'accoutn_type_title' => $this->accountType->title,
            'accoutn_type_slug' => $this->accountType->slug,
            'account_name' => $this->account_name,
            'account_number' => $this->account_number,
            'routing_numer' => $this->routing_numer,
            'branch' => $this->branch,
            'opening_date' => $this->opening_date,
            'balance' => $this->balance,
            'status' => (bool)$this->status,
        ];
    }
}
