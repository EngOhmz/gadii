<?php

namespace App\Models\Pharmacy;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $table = "pharmacy_pos_invoices";
    protected  $guarded = ['id'];


    public function invoice_items(){

        return $this->hasMany('App\Models\Pharmacy\InvoiceItems','id');
    }
    
    public function client(){
    
        return $this->BelongsTo('App\Models\Pharmacy\Client','client_id');
    }
  public function store(){
    
        return $this->BelongsTo('App\Models\Location','location');
    }
}
