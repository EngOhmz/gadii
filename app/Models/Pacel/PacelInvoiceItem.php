<?php

namespace App\Models\Pacel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PacelInvoiceItem extends Model
{
    use HasFactory;

    protected $table = "pacel_invoice_items";

  protected $guarded = ['id','_token'];
    

    public function  route(){
    
        return $this->belongsTo('App\Models\Route','route_id');
      }

      public function  supplier(){
    
        return $this->belongsTo('App\Models\Client','owner_id');
      }

 public function user(){
    
        return $this->belongsTo('App\Models\User','added_by');
      }
}
