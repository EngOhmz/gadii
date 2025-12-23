<?php

namespace App\Models\Retail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseItems extends Model
{
    use HasFactory;

    protected $table  = "retail_pos_purchase_items";

    protected $guarded = ['id'];

    public function purchase(){

        return $this->BelongsTo('App\Models\Retail\Purchase','id');
    }
}
