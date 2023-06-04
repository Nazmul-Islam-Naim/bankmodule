<?php

namespace App\Http\Resources\SocialMedia;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

class SocialMediaResources extends JsonResource
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
            'title' => $this->title,
            'link' => $this->link,
            'status' => (bool)$this->status,
            'icon' => $this->icon->path ? Storage::url($this->icon->path) : $this->icon->path
        ];
    }
}
