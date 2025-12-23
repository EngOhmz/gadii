<?php

namespace App\Models\Pharmacy\POS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Items1 extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $table = "pharmacy_tbl_items1";
}
