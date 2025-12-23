<?php

namespace App\Models\Bar\POS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseItems extends Model
{
    use HasFactory;

    protected $table  = "store_pos_purchase_items";

    protected $guarded = ['id'];

    public function purchase(){

        return $this->BelongsTo('App\Models\Bar\POS\Purchase','id');
    }
}
