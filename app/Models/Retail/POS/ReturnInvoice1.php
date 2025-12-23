<?php

namespace App\Models\Pharmacy\POS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnInvoice1 extends Model
{
    use HasFactory;
    protected $table = "pharmacy_pos_return_invoices1";
    protected  $guarded = ['id'];


    public function invoice(){

        return $this->BelongsTo('App\Models\Pharmacy\POS\Invoice1','invoice_id');
    }
    
    public function client(){
    
        return $this->BelongsTo('App\Models\Pharmacy\Client1','client_id');
    }
    
    
}
