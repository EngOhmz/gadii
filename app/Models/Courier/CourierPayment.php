<?php

namespace App\Models\Courier;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourierPayment extends Model
{
    use HasFactory;

    protected $table = "courier_payments";

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
