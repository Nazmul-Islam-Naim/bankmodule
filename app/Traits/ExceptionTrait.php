<?php

namespace App\Traits;

use Exception;
use Illuminate\Support\Facades\Log;
use Throwable;

trait ExceptionTrait
{
    public function generalException(Throwable $exception, $message = null, $code = 500){
        Log::error($exception);
        $message = $message?$message:'Something went Wrong';
        throw new Exception($message, 500);
    }
}
