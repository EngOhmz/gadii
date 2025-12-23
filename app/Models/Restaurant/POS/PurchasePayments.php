<?php

namespace App\Models\Restaurant\POS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchasePayments extends Model
{
    use HasFactory;

    protected $table = "restaurant_pos_purchase_payments";

    protected $guarded = ['id'];

  public function payment(){
    
        return $this->BelongsTo('App\Models\AccountCodes','account_id');
    }

public function first(){

        return $this->belongsTo('App\Models\User','approval_1');
    }
 public function second(){

        return $this->belongsTo('App\Models\User','approval_2');
    }
 public function user(){

        return $this->belongsTo('App\Models\User','added_by');
    }
}
