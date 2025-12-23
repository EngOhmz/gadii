<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory1 extends Model
{
    use HasFactory;

    protected $table = "inventories1";

    protected $fillable = [
    'name',
    'unit',
    'quantity',
    'price',
    'added_by'];
    
    public function user()
    {
        return $this->belongsTo('App\Models\user');
    }


    
}
