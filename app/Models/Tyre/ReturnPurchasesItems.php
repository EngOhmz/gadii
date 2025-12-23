<?php

namespace App\Models\Tyre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnPurchasesItems extends Model
{
    use HasFactory;

    protected $table = "tyre_return_purchases_items";
    protected  $guarded = ['id'];
}
