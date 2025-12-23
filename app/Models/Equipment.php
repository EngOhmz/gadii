<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;
    protected $table = 'equipments';

    protected  $guarded = ['id'];
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

   
}