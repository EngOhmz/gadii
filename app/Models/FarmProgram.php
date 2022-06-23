<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FarmProgram extends Model
{
    use HasFactory;
    protected $table = "farm_program";

    protected $fillable = [      
    'season_id',
        'name',
      'gap',
        'cost',
        'acre',
        'total_cost',  
        'distributor',      
        'added_by'];

    public function farm_gap()
    {
        return $this->belongsTo('App\Models\Farming_process','gap');
    }


    
    public function user()
    {
        return $this->belongsTo('App\Models\user');
    }
}
