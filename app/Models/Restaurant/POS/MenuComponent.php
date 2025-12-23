<?php

namespace App\Models\Restaurant\POS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuComponent extends Model
{
 
    use HasFactory;

    protected $table = 'menu_component';
  protected  $guarded = ['id'];
}

