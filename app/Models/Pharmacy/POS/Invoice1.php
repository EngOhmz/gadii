<?php

namespace App\Models\Pharmacy\POS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice1 extends Model
{
    use HasFactory;
    protected $table = "pharmacy_pos_invoices1";
    protected  $guarded = ['id'];


    public function invoice_items(){

        return $this->hasMany('App\Models\Pharmacy\POS\InvoiceItems1','id');
    }
    
    public function client(){
    
        return $this->BelongsTo('App\Models\Pharmacy\Client1','client_id');
    }
}
