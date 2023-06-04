<?php

namespace App\Models;

use App\Enum\Status;
use App\Traits\TranslatableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Vendor extends Authenticatable implements JWTSubject
{
    use HasFactory, SoftDeletes, TranslatableTrait;

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

    protected $fillable = ['vendorid', 'email', 'phone','password','email_varified_at', 'phone_verified_at','status','warehouse','returnaddress','verified'];

    //relationships

    public function logo(){
        return $this->morphOne(Media::class,'mediable')->withDefault([
            'type'=>'image',
            'provider'=>'public',
            'path' => null,
        ]);
    }

    public function bankAccount(){
        return $this->hasOne(BankAccount::class);
    }

    public function businessInfo(){
        return $this->hasOne(BusinessInfo::class);
    }

    public function addresses(){
        return $this->morphMany(Address::class,'addressable');
    }

    public function deliveries(){
        return $this->belongsToMany(Delivery::class);
    }

     //methods

     public function getStatusAttribute($value){
        return Status::tryFrom($value)?Status::from($value)->toString():null;
    }

}
