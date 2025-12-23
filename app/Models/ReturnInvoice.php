<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnInvoice extends Model
{
    use HasFactory;
    protected $table = "inventory_return_invoices";
    protected  $guarded = ['id'];


    public function invoice(){

        return $this->BelongsTo('App\Models\Invoice','invoice_id');
    }
    
    public function client(){
    
        return $this->BelongsTo('App\Models\Client','client_id');
    }
    
    public function payment(){
    
        return $this->BelongsTo('App\Models\AccountCodes','bank_id');
    }
}
