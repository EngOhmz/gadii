<?php

namespace App\Models\Cotton;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceCotton extends Model
{
    use HasFactory;

    protected $table = "cotton_invoice";

     protected $guarded = ['id','_token'];

    
  public function user()
    {
        return $this->belongsTo('App\Models\User','added_by');
    }

 public function  supplier(){
    
        return $this->belongsTo('App\Models\ChartOfAccount','supplier_id');
      }
 public function  location_id(){
    
        return $this->belongsTo('App\Models\Cotton\CollectionCenter','location');
      }

}
