<?php

namespace App\Models\ Pharmacy;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseItems extends Model
{
    use HasFactory;

    protected $table  = "pharmacy_pos_purchase_items";

    protected $guarded = ['id'];

    public function purchase(){

        return $this->BelongsTo('App\Models\Pharmacy\Purchase','id');
    }
}
