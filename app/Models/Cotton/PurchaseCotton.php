<?php

namespace App\Models\Cotton;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseCotton extends Model
{
    use HasFactory;

    protected $table = "purchase_cotton";

    protected $fillable = [
    'reference_no',
     'reference',
     'weight',
    'supplier_id',
    'district_id',
    'purchase_date',
    'due_date',
    'location',
    'exchange_code',
    'exchange_rate',
    'purchase_amount',
    'due_amount',
    'purchase_tax',
    'status',
     'tax_rate',
    'quantity',
    'price',
    'unit',
   'item_id',
    'good_receive',    
    'added_by'];

    
  public function user()
    {
        return $this->belongsTo('App\Models\User','added_by');
    }

 public function  supplier(){
    
        return $this->belongsTo('App\Models\Cotton\Operator','supplier_id');
      }
 public function  location_id(){
    
        return $this->belongsTo('App\Models\Cotton\CollectionCenter','location');
      }

}
