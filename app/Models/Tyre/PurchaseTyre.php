<?php

namespace App\Models\Tyre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseTyre extends Model
{
    use HasFactory;

    protected $table = "purchase_tyres";

    protected  $guarded = ['id'];
    
    public function user()
    {
        return $this->belongsTo('App\Models\User','added_by');
    }

 public function  supplier(){
    
        return $this->belongsTo('App\Models\Supplier','supplier_id');
      }



}
