<?php

namespace App\Models\Restaurant\POS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $table  = "restaurant_pos_purchases";

    protected $guarded = ['id'];

public function purchase_items(){

    return $this->hasMany('App\Models\Restaurant\POS\PurchaseItems','id');
}

public function supplier(){

    return $this->BelongsTo('App\Models\Restaurant\POS\Supplier','supplier_id');
}

 public function user(){

        return $this->belongsTo('App\Models\User','added_by');
    }
public function first(){

        return $this->belongsTo('App\Models\User','approval_1');
    }
 public function second(){

        return $this->belongsTo('App\Models\User','approval_2');
    }
 public function third(){

        return $this->belongsTo('App\Models\User','approval_3');
    }
}
