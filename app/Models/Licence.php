<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Licence extends Model
{
    use HasFactory;

    protected $table = "licences";

    protected $fillable = ['class','year','expire','attachment','driver_id','added_by'];
    
    public function user()
    {
        return $this->belongsTo('App\Models\user');
    }
}
