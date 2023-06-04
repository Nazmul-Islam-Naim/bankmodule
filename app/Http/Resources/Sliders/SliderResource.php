<?php

namespace App\Http\Resources\Sliders;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class SliderResource extends JsonResource
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
            'url' => $this->url,
            'background_color' => $this->background_color,
            'slider_image' => $this->sliderImage->path ? Storage::url($this->sliderImage->path) : $this->sliderImage->path,
            'status' => (bool)$this->status
        ];
    }
}
