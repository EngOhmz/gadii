<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnPurchasesPayments extends Model
{
    use HasFactory;

    protected $table = "pos_return_purchases_payments";
    protected  $guarded = ['id'];
}
