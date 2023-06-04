<?php

namespace App\Traits;

trait ApiResourcePaginateTrait
{
   
    public function generateInfo(){
        return [

            'items' =>  $this->collection,

            //Paginator meta discription
            'meta'  =>  [
                'current_page' => $this->resource->currentPage(),
                'first_page_url' => $this->resource->url(1),
                'from' => $this->resource->firstItem(),
                'last_page' => $this->resource->lastPage(),
                'last_page_url' => $this->resource->url($this->resource->lastPage()),
                'next_page_url' => $this->resource->nextPageUrl(),
                'path' => $this->resource->path(),
                'per_page' => $this->resource->perPage(),
                'prev_page_url' => $this->resource->previousPageUrl(),
                'to' => $this->resource->lastItem(),
                'total' => $this->resource->total(),
            ],

            //paginator links
            'links' => $this->resource->linkCollection()->toArray(),
        ];
    }

}
