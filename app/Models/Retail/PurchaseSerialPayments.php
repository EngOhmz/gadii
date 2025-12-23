<?php

namespace App\Models\Retail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseSerialPayments extends Model
{
    use HasFactory;

    protected $table = "retail_pos_purchase_serial_payments";

    //protected $quarded = ['id','_token'];
    protected $guarded = ['id'];
}
