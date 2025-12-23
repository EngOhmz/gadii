<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseSerial extends Model
{
    use HasFactory;

    protected $table  = "pos_serial_purchases";

    protected $guarded = ['id'];

public function purchase_items(){

    return $this->hasMany('App\Models\POS\PurchaseSerialItems','id');
}

public function supplier(){

    return $this->BelongsTo('App\Models\Supplier','supplier_id');
}
}
