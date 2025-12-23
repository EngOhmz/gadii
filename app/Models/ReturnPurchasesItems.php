<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnPurchasesItems extends Model
{
    use HasFactory;

    protected $table = "inventory_return_purchases_items";
    protected  $guarded = ['id'];
}
