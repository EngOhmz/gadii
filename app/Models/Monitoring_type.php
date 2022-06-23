<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Monitoring_type extends Model
{
    use HasFactory;

    protected $table = "tbl_monitoring_type";

    protected $fillable = ['type'];
    public function user()
    {
        return $this->belongsTo('App\Models\user');
    }
    public function group()
    {
        return $this->belongsTo('App\Models\Group');
    }
    public function land()
    {
        return $this->hasMany('App\Models\Land_properties','id');
    }
}
