<?php

namespace App\Log\Drivers;

use Illuminate\Support\Facades\Log;

class Gelf 
{
    public function set($log){
        Log::channel("gelf")->info(json_encode($log,true));
    }
}