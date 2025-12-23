<?php

namespace App\Models\Retail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $table = "retail_pos_invoices";
    protected  $guarded = ['id'];


    public function invoice_items(){

        return $this->hasMany('App\Models\Retail\InvoiceItems','id');
    }
    
    public function client(){
    
        return $this->BelongsTo('App\Models\Retail\Client','client_id');
    }
  public function store(){
    
        return $this->BelongsTo('App\Models\Retail\Location','location');
    }
}
