<?php

namespace App\Http\Resources\Users;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class UserResources extends JsonResource
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
            'id'        =>  $this->id,
            'username'  =>  $this->username,
            'avatar'    =>  Storage::url($this->avatar)
        ];
    }
}
