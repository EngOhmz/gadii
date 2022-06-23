<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment_methodes extends Model
{
    //

    protected $table = "payment_methodes";

    protected $fillable = [
        'name',
        'description',
    ];

    public function payments()
    {
        return $this->hasMany('App\Models\Payments','id');
    }

    
    public function invoice_payment()
    {
        return $this->hasMany('App\Models\Invoice_payment','id');
    }
}
