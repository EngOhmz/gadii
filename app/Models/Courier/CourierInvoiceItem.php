<?php

namespace App\Models\Courier;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourierInvoiceItem extends Model
{
    use HasFactory;

    protected $table = "courier_invoice_items";

   protected $guarded = ['id','_token'];
    
    public function user()
    {
        return $this->belongsTo('App\Models\user');
    }

public function start(){
    
        return $this->belongsTo('App\Models\Region','from_region_id');
      }

public function end(){
    
        return $this->belongsTo('App\Models\Region','to_region_id');
      }
public function collect(){
    
        return $this->belongsTo('App\Models\Courier\CourierCollection','collection_id');
      }
}
