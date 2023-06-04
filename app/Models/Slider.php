<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Slider extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'sliders';
    protected $fillable = ['title','url','background_color','status','deleted_at'];

    public function sliderImage()
    {
        return $this->morphOne(Media::class, 'mediable')->withDefault([
            'type' => 'image',
            'provider' => 'public',
            'path' => null,
        ]);
    }
}
