<?php

namespace App\Models\Retail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseSerial extends Model
{
    use HasFactory;

    protected $table  = "retail_pos_purchases_serial";

    protected $guarded = ['id'];

public function purchase_items(){

    return $this->hasMany('App\Models\Retail\PurchaseSerialItems','id');
}

public function supplier(){

    return $this->BelongsTo('App\Models\Retail\Supplier','supplier_id');
}
}
