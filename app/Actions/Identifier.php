<?php

namespace App\Actions;

use App\Helpers\Helper;

class Identifier
{
    public $identifier;

    public function __toString()
    {
        return Helper::decrypt($this->identifier);
    }

    public function __invoke()
    {
        return Helper::decrypt($this->identifier);
    }

    public function getValue(){
        return Helper::decrypt($this->identifier);
    }
}
