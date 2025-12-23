<?php

namespace App\Models\Pharmacy;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $table  = "pharmacy_pos_purchases";

    protected $guarded = ['id'];

public function purchase_items(){

    return $this->hasMany('App\Models\Pharmacy\PurchaseItems','id');
}

public function supplier(){

    return $this->BelongsTo('App\Models\Pharmacy\Supplier','supplier_id');
}
}
