<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    //
    protected $table="payments";

    protected $fillable = [
        'trans_id',
        'payment_methode_id',
        'amount',
        'due_amount',
        'notes',
        'date',
        'supplier_id',
        'client_id',
        'purchase_id',
        'invoice_id',
        
    ];

    public function payment_methodes(){

        return $this->belongTo('App\Models\Payment_methodes','payment_methode_id');
    }
}
