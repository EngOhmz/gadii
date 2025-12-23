<?php

namespace App\Models\Restaurant\POS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $table = "restaurant_pos_clients";
    protected  $guarded = ['id'];
}
