<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoicePayments extends Model
{
    use HasFactory;

    
    protected $table = "pos_invoice_payments";

    //protected $quarded = ['id','_token'];
    protected $guarded = ['id'];

 public function payment(){
    
        return $this->BelongsTo('App\Models\AccountCodes','account_id');
    }
    
     
    public function invoice(){
    
        return $this->BelongsTo('App\Models\POS\Invoice','invoice_id');
    }

}

