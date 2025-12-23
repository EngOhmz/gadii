<?php

namespace App\Models\Retail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $table = "retail_locations";

  protected $guarded = ['id','_token'];
    public function user()
    {
        return $this->belongsTo('App\Models\user');
    }
}
