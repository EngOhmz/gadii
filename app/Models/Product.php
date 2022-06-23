<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';

    protected $fillable = ['user_id','name','code','buyprice','sellprice','unit','balance'];
    public function user()
    {
        return $this->belongsTo('App\Models\user');
    }
    public function orders()
    {
        return $this->belongsTo('App\Models\order');
    }
    
}
