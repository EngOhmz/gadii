<?php

namespace App\Models\Pharmacy;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseSerialItems extends Model
{
    use HasFactory;

    protected $table  = "pharmacy_pos_purchases_serial_items";

    protected $guarded = ['id'];

    public function purchase(){

        return $this->BelongsTo('App\Models\Pharmacy\PurchaseSerial','id');
    }
}
