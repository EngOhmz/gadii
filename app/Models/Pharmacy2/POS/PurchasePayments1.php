<?php

namespace App\Models\Pharmacy\POS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchasePayments1 extends Model
{
    use HasFactory;

    protected $table = "pharmacy_pos_purchase_payments1";

    //protected $quarded = ['id','_token'];
    protected $guarded = ['id'];
}
