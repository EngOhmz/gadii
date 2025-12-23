<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FieldStaff extends Model
{
    use HasFactory;

    protected $table = "field_staff";

    protected $guarded = ['id'];
    
    public function user()
    {
        return $this->belongsTo('App\Models\user');
    }

}
