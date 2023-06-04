<?php

namespace App\Http\Resources\Roles;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Crypt;

class RoleSelectResources extends JsonResource
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
            'id'=>Crypt::encryptString($this->id),
            "title" =>  $this->title,
            "slug"  =>  $this->slug
        ];
    }
}
