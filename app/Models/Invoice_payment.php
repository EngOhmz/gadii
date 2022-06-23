<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice_payment extends Model
{
    //
    protected $table="tbl_invoice_payments";

    protected $fillable = [
        'trans_id',
        'payment_methode_id',
        'amount',
        'due_amount',
        'notes',
        'date',
        'client_id',
        'invoice_id',
        
    ];

    public function payment_methodes(){

        return $this->belongTo('App\Models\Payment_methodes','payment_methode_id');
    }
}
