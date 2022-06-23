<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $table = "services";

 protected $fillable = [      
         'truck',
         'truck_name',
     'reg_no',
         'driver',
         'mechanical',
         'date',
         'reading',
         'history',     
        'major',
          'report',  
        'status',   
        'added_by'];

        public function user()
        {
            return $this->belongsTo('App\Models\user');
        }
}
