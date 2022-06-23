<?php

namespace App\Models\orders;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderPayment extends Model
{
    use HasFactory;

    protected $table = "order_payments";

    protected $fillable = [
    'transport_id',
    'trans_id',
    'amount',
    'date',
    'payment_method',
    'notes',   
    'added_by'];
    
    public function user()
    {
        return $this->belongsTo('App\Models\user');
    }
}
