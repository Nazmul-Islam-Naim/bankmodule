<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SocialMedia extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'social_media';
    protected $fillable = ['title', 'link', 'status', 'deleted_at'];

    public function icon(){
        return $this->morphOne(Media::class, 'mediable')->withDefault([
            'type' => 'image',
            'provider' => 'public',
            'path' => null,
        ]);
    }
}
