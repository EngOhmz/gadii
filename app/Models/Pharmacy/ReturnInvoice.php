<?php

namespace App\Models\Pharmacy;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnInvoice extends Model
{
    use HasFactory;
    protected $table = "pharmacy_pos_return_invoices";
    protected  $guarded = ['id'];


    public function invoice(){

        return $this->BelongsTo('App\Models\Pharmacy\Invoice','invoice_id');
    }
    
    public function client(){
    
        return $this->BelongsTo('App\Models\Pharmacy\Client','client_id');
    }
}
