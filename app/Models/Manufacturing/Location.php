<?php

namespace App\Models\Manufacturing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $table = "manufacturing_locations";

    protected $fillable = [
    'name',
     'store_type',
      'manager',
    'added_by'];
    
    public function user()
    {
        return $this->belongsTo('App\Models\user');
    }
}
