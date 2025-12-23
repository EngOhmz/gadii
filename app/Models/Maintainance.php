<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maintainance extends Model
{
    use HasFactory;

    protected $table = "maintainances";

   protected $guarded = [
         'id',      
       'token'];
    
        public function user()
        {
            return $this->belongsTo('App\Models\user');
        }
}
