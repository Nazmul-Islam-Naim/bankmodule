<?php

namespace App\Models;

use App\Enum\Type;
use App\Helpers\Helper;
use App\Traits\Filters;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Role extends Model
{
    use HasFactory,SoftDeletes;


    protected $fillable = ['title','slug'];


    //relationships

    public function permissions(){
        return $this->belongsToMany(Permission::class);
    }

    public function user(){
        return $this->hasMany(User::class,'role_id','id');
    } 

}