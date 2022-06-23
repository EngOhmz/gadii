<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    use HasFactory;

    protected $table = "routes";

    protected $guarded = ['id','_token'];

         
    
    public function user()
    {
        return $this->belongsTo('App\Models\user');
    }
}
