<?php

namespace App\Models\Pharmacy;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;
    protected $table = 'pharmacy_suppliers';

    protected $fillable = ['user_id','name','address','phone','TIN','email'];
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function purchase()
    {
        return $this->hasMany('App\Models\Pharmacy\Purchase1','id');
    }
}