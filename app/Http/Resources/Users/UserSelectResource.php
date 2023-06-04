<?php

namespace App\Http\Resources\Users;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class UserSelectResource extends JsonResource
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
            "id"    =>  $this->id,
            "name"  =>  $this->name,
            "avatar"=>  Storage::url($this->avatar)
        ];
    }
}
