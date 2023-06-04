<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    protected $fillable = ['type','mediable_id','mediable_type','provider','path','tag'];

    //relationships

    public function mediable(){
        return $this->morphTo();
    }

    //method


}
