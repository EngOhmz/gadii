<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnPurchasesItems extends Model
{
    use HasFactory;

    protected $table = "pos_return_purchases_items";
    protected  $guarded = ['id'];
}
