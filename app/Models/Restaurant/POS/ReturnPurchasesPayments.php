<?php

namespace App\Models\Restaurant\POS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnPurchasesPayments extends Model
{
    use HasFactory;

    protected $table = "restaurant_pos_return_purchases_payments";
    protected  $guarded = ['id'];
}
