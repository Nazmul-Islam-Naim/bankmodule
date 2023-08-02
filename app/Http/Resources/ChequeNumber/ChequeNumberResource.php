<?php

namespace App\Http\Resources\ChequeNumber;

use App\Enum\ChequeStatus;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Crypt;

class ChequeNumberResource extends JsonResource
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
          'id' => Crypt::encrypt($this->id),  
          'cheque_book_id' => Crypt::encrypt($this->chequeBook->id),  
          'cheque_book_title' => $this->chequeBook->title,  
          'cheque_number' => $this->cheque_number,  
          'status' => ChequeStatus::getFromValue($this->status)->name,  
        ];
    }
}
