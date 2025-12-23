<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier1 extends Model
{
    use HasFactory;
    protected $table = 'suppliers1';

    protected $fillable = ['user_id','name','address','phone','TIN','email'];
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function purchase()
    {
        return $this->hasMany('App\Models\Purchase1','id');
    }
}