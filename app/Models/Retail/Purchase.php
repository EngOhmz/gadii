<?php

namespace App\Models\Retail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $table  = "retail_pos_purchases";

    protected $guarded = ['id'];

public function purchase_items(){

    return $this->hasMany('App\Models\Retail\PurchaseItems','id');
}

public function supplier(){

    return $this->BelongsTo('App\Models\Retail\Supplier','supplier_id');
}
}
