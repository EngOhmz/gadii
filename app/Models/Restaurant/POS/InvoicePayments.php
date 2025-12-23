<?php

namespace App\Models\Restaurant\POS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoicePayments extends Model
{
    use HasFactory;

    protected $table = "restaurant_pos_invoice_payments";

    protected $guarded = ['id'];

  public function payment(){
    
        return $this->BelongsTo('App\Models\AccountCodes','account_id');
    }
}
