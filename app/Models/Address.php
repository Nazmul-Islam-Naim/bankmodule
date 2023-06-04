<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = ['addressable_id','addressable_type','details','verified','addressline', 'type'];


    protected $casts = [
        'details' => 'array',
    ];


    //relationships

    public function addressable(){
        return $this->morphTo();
    }
}
