<?php

namespace App\Models\Pharmacy\POS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseItems1 extends Model
{
    use HasFactory;

    protected $table  = "pharmacy_pos_purchase_items1";

    protected $guarded = ['id'];

    public function purchase(){

        return $this->BelongsTo('App\Models\Pharmacy\POS\Purchase1','id');
    }
}
