<?php

namespace App\Models\manufacturing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $table = "manufacturing_inventories";

    protected $fillable = [
    'name',
    'product_type',
    'unit',
    'quantity',
    'price',
    'added_by'];
    
    public function user()
    {
        return $this->belongsTo('App\Models\user');
    }


    
}
