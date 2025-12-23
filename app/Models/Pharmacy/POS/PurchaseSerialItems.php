<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseSerialItems extends Model
{
    use HasFactory;

    protected $table  = "pos_serial_purchases_items";

    protected $guarded = ['id'];

    public function purchase(){

        return $this->BelongsTo('App\Models\POS\PurchaseSerial','id');
    }
}
