<?php

namespace App\Models\Pharmacy;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseSerial extends Model
{
    use HasFactory;

    protected $table  = "pharmacy_pos_purchases_serial";

    protected $guarded = ['id'];

public function purchase_items(){

    return $this->hasMany('App\Models\Pharmacy\PurchaseSerialItems','id');
}

public function supplier(){

    return $this->BelongsTo('App\Models\Pharmacy\Supplier','supplier_id');
}
}
