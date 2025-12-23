<?php

namespace App\Models\Pharmacy;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceHistory extends Model
{
    use HasFactory;
    protected $table = "pharmacy_pos_invoices_history";
    protected  $guarded = ['id','_token'];


    public function invoice(){

        return $this->BelongsTo('App\Models\Pharmacy\Invoice','invoice_id');
    }
    
    public function client(){
    
        return $this->BelongsTo('App\Models\Pharmacy\Client','client_id');
    }
}
