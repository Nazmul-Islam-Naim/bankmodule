<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChequeTransaction extends Model
{
    use HasFactory;
    protected $table = 'cheque_transactions';
    protected $fillable = ['cheque_number_id', 'creator_id', 'approver_id', 'payee_name', 'payer_name', 'amount', 'cheque_date', 'signature', 'note', 'status'];

    public function chequeNumber(){
        return $this->belongsTo(ChequeNumber::class);
    }

    public function creator(){
        return $this->belongsTo(Admin::class,'creator_id');
    }

    public function approver(){
        return $this->belongsTo(Admin::class,'approver_id');
    }
}
