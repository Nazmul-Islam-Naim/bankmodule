<?php

namespace App\Http\Resources\Logo;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

class LogoResource extends JsonResource
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
            'fav_icon' => $this->logos()->first()->path ? Storage::url($this->logos()->first()->path) : $this->logos()->first()->path,
            'header_logo' => $this->logos()->skip(1)->first()->path ? Storage::url($this->logos()->skip(1)->first()->path) : $this->logos()->skip(1)->first()->path,
            'footer_logo' => $this->logos()->skip(2)->first()->path ? Storage::url($this->logos()->skip(2)->first()->path) : $this->logos()->skip(2)->first()->path,
            'status' => (bool)$this->status
        ];
    }
}
