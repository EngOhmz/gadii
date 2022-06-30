<?php

namespace App\Models\Courier;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourierList extends Model
{
    use HasFactory;

    protected $table = "courier_lists";

    protected $fillable = [
    'name',
    'unit',
    'price',
    'quantity',
    'added_by'];
    
    public function user()
    {
        return $this->belongsTo('App\Models\user');
    }
}
