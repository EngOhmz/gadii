<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
    use HasFactory;
    protected $table = 'balances';
    protected $fillable = ['user_id','product_id','purchase','sale','cost'];
    public function user()
    {
        return $this->belongsTo('App\Models\user');
    }
}
