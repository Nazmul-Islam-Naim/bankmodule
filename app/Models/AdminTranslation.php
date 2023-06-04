<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminTranslation extends Model
{
    use HasFactory;

    protected $fillable = ['local','firstname' ,'lastname','admin_id'];

    //relationships

    public function admin(){
        return $this->belongsTo(Admin::class);
    }
}
