<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocationManager extends Model
{
    use HasFactory;

    protected $table = "location_manager";

  protected $guarded = ['id','_token'];

    public function user()
    {
        return $this->belongsTo('App\Models\User','manager');
    }
}
