<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Logo extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'logos';
    protected $fillable = ['title', 'status', 'deleted_at'];

    public function logo(){
        return $this->morphOne(Media::class, 'mediable')->withDefault([
            'type' => 'image',
            'provider' => 'public',
            'path' => null
        ]);
    }
    public function logos(){
        return $this->morphMany(Media::class, 'mediable');
    }
}
