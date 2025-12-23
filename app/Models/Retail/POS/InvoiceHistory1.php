<?php

namespace App\Models\Pharmacy\POS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceHistory1 extends Model
{
    use HasFactory;
    protected $table = "pharmacy_pos_invoices_history1";
    protected  $guarded = ['id','_token'];


    public function invoice(){

        return $this->hasMany('App\Models\Pharmacy\POS\Invoice1','invoice_id');
    }
    
    public function client(){
    
        return $this->BelongsTo('App\Models\Pharmacy\Client1','client_id');
    }
}
