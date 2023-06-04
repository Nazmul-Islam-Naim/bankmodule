<?php

namespace App\Traits;

use App\Services\FileService;

trait FSMTRAIT
{
    
    public function upload($file, $directory ,$provider = null){
        return (new FileService($file, $directory ,$provider))->upload();
    }
    
 
    public function cleanAndUpload($file, $directory, $actualpath ,$provider=null){
        return (new FileService($file, $directory ,$provider))->cleanAndUpload( $actualpath);
    }    
    

    public function unlink($actualpath, $provider=null){
        return FileService::fileunlink($actualpath, $provider);
    }
    
}