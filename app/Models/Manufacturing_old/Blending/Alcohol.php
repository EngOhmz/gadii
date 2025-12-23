<?php

namespace App\Models\Manufacturing\Blending;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alcohol extends Model
{
    use HasFactory;
    protected $table = 'alcohols';
    protected $fillable = ['percentage'];
    
    public function blending(){
        return $this->hasMsny('App\Models\Manufacturing\Vlending\Blending','alcohol_id');
    }

    
}
