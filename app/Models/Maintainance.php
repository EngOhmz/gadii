<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maintainance extends Model
{
    use HasFactory;

    protected $table = "maintainances";

    protected $fillable = [      
         'truck',
         'truck_name',
        'reg_no',
         'driver',
         'mechanical',
         'date',
         'type',
         'reason',  
       'report',   
        'status',   
        'added_by'];
        public function user()
        {
            return $this->belongsTo('App\Models\user');
        }
}
