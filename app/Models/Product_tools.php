<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_tools extends Model
{
    use HasFactory;
    protected $table = 'tbl_product_tools';

    protected $fillable = ['tool_name','owner_id','quantity','units','status'];
    
    public function owner()
    {
        return $this->belongsTo('App\Models\Farmer','owner_id');
    }
    public function orders()
    {
        return $this->belongsTo('App\Models\order');
    }
    
}