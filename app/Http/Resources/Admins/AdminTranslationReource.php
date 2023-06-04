<?php

namespace App\Http\Resources\Admins;

use Illuminate\Http\Resources\Json\JsonResource;


class AdminTranslationReource extends JsonResource
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
            "local"=>$this->local,
            "firstname"=>$this->firstname,
            "lastname"=>$this->lastname
        ];
    }
}
