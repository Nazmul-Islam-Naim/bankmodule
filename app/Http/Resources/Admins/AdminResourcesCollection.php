<?php

namespace App\Http\Resources\Admins;

use App\Traits\ApiResourcePaginateTrait;
use Illuminate\Http\Resources\Json\ResourceCollection;

class AdminResourcesCollection extends ResourceCollection
{
    use ApiResourcePaginateTrait;
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
       return $this->generateInfo(); 
    }
}
