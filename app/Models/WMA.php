<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WMA extends Model
{
    use HasFactory;

    protected $table = "wma";

     protected $guarded = ['id','_token'];
    
    public function user()
    {
        return $this->belongsTo('App\Models\user');
    }
    
       public function supplier()
    {
        return $this->belongsTo('App\Models\Supplier','officer');
    }
}
