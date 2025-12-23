<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $table = "locations";

  protected $guarded = ['id','_token'];
    public function user()
    {
        return $this->belongsTo('App\Models\user');
    }

  public function owner()
    {
        return $this->belongsTo('App\Models\LocationManager','id');
    } 
}
