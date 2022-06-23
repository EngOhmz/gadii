<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deposite_withdraw extends Model
{
    use HasFactory;
    protected $table = "tbl_deposite_withdraw";

    protected $fillable = ['farm_account_id','quantity','cost','status'];
    public function farmer_account()
    {
        return $this->belongsTo('App\Models\Farmer_account','farm_account_id');
    }
}