<?php

namespace App\Models\Bar\POS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $table  = "store_pos_purchases";

    protected $guarded = ['id'];

public function purchase_items(){

    return $this->hasMany('App\Models\Bar\POS\PurchaseItems','id');
}

public function supplier(){

    return $this->BelongsTo('App\Models\Bar\POS\Supplier','supplier_id');
}
}
