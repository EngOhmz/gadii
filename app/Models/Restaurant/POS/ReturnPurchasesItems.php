<?php

namespace App\Models\Restaurant\POS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnPurchasesItems extends Model
{
    use HasFactory;

    protected $table = "restaurant_pos_return_purchases_items";
    protected  $guarded = ['id'];
}
