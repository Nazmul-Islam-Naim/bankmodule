<?php

namespace App\Http\Resources\Admins;

use App\Http\Resources\Roles\RoleResources;
use App\Traits\TranslationResourceTrait;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

class AdminResource extends JsonResource
{
    use TranslationResourceTrait;
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
            'phone'=>$this->phone,
            'email'=>$this->email,
            'translations'=>AdminTranslationReource::collection($this->availabletanslations()),
            'emailverified'=>(bool)$this->email_verified_at,
            'phoneverified'=>(bool)$this->phone_verified_at,
            'email_verified_at'=>$this->email_verified_at,
            'phone_verified_at'=>$this->phone_verified_at,
            'role'=>new RoleResources($this->role),
            'avatar'=>$this->avatar?Storage::url($this->avatar->path):null,
            'status'=>$this->status,
        ];
    }
}
