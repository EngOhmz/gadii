<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FarmLand extends Model
{
    use HasFactory;
    protected $table = "farm_lands";

    protected $fillable = ['farmer_id','user_id','location','size','regno','ownership'];
    
    public function farmer()
    {
        return $this->belongsTo('App\Models\Farmer');
    }
    
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    
}
