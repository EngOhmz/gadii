<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Items2 extends Model
{
    //

    protected $table = 'tbl_farming_processes';
    
     


    protected $fillable = [
        'price',
        'name',
        'unit',
        'user_id',
    ];
    
}