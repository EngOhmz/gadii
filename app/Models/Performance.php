<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Performance extends Model
{
    use HasFactory;

    protected $table = "performances";

    protected $fillable = ['issue','date','reason','explanation','effect','attachment','driver_id','added_by'];
    
    public function user()
    {
        return $this->belongsTo('App\Models\user');
    }
}
