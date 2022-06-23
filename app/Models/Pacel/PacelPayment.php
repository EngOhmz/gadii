<?php

namespace App\Models\Pacel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PacelPayment extends Model
{
    use HasFactory;

    protected $table = "pacel_payments";

    protected $fillable = [
    'pacel_id',
    'trans_id',
    'amount',
    'date',
    'payment_method',
    'notes', 
'account_id', 
    'added_by'];
    
    public function user()
    {
        return $this->belongsTo('App\Models\user');
    }
}
