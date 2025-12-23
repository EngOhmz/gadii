<?php

namespace App\Models\Pharmacy\POS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase1 extends Model
{
    use HasFactory;

    protected $table  = "pharmacy_pos_purchases1";

    protected $guarded = ['id'];

public function purchase_items(){

    return $this->hasMany('App\Models\Pharmacy\POS\PurchaseItems1','id');
}

public function supplier(){

    return $this->BelongsTo('App\Models\Pharmacy\Supplier1','supplier_id');
}
}
