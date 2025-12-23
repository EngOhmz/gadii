<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceHistory extends Model
{
    use HasFactory;
    protected $table = "inventory_invoices_history";
    protected  $guarded = ['id','_token'];


    public function invoice(){

        return $this->BelongsTo('App\Models\Invoice','invoice_id');
    }


    
    public function client(){
    
        return $this->BelongsTo('App\Models\Client','client_id');
    }

 public function  store(){
    
        return $this->belongsTo('App\Models\Location','location');
      }
}
