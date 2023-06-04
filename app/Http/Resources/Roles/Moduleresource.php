<?php

namespace App\Http\Resources\Roles;

use Illuminate\Http\Resources\Json\JsonResource;

class Moduleresource extends JsonResource
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
            "title"      => $this->title,
            "slug"       => $this->slug,
            "permissions"=> PermissionResource::collection($this->permissions)
        ];
    }
}
