<?php

namespace App\Models\Courier;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProformaInvoice extends Model
{
    use HasFactory;
    protected $table = "courier_proforma";
    protected  $guarded = ['id'];


    public function invoice_items(){

        return $this->hasMany('App\Models\Courier\ProformaInvoiceItems','id');
    }
    
    public function client(){
    
        return $this->BelongsTo('App\Models\Courier\CourierClient','client_id');
    }
 public function  store(){
    
        return $this->belongsTo('App\Models\Location','location');
      }
}
