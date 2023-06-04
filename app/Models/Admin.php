<?php

namespace App\Models;

use App\Enum\Status;
use App\Traits\TranslatableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable implements JWTSubject
{
    use HasFactory, TranslatableTrait, SoftDeletes;


    // Rest omitted for brevity

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    protected $fillable = ['phone','email','password','role_id','email_verified_at','phone_verified_at','status','deleted_at'];


    //relationships

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function avatar(){
        return $this->morphOne(Media::class,'mediable')->where('tag','avatar');
    }




    //methods

    public function getStatusAttribute($value)
    {
        return Status::tryFrom($value) ? Status::from($value)->toString() : null;
    }
}
