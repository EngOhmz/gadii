<?php

namespace App\Models\Restaurant\POS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $table = "restaurant_pos_items";
}
