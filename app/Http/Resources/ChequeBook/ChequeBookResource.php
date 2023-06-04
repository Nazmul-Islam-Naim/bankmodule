<?php

namespace App\Http\Resources\ChequeBook;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Crypt;

class ChequeBookResource extends JsonResource
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
            'bank_id' => Crypt::encryptString($this->bank->id),
            'bank_title' => $this->bank->title,
            'bank_slug' => $this->bank->slug,
            'title' => $this->title,
            'slug' => $this->slug,
            'status' => (bool)$this->status,
        ];
    }
}
