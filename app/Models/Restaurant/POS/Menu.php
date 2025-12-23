<?php

namespace App\Models\Restaurant\POS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
 
    use HasFactory;

    protected $table = 'menus';
  protected  $guarded = ['id'];
}

