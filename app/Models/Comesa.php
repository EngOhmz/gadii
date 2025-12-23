<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comesa extends Model
{
    use HasFactory;

    protected $table = "comesa";

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
