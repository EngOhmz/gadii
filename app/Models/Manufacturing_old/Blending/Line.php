<?php

namespace App\Models\Manufacturing\Blending;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Line extends Model
{
    use HasFactory;
    protected $table = 'lines';
    protected $fillable = ['line_number'];
    
    public function blending(){
        return $this->hasMsny('App\Models\Manufacturing\Vlending\Line','line_id');
    }

    
}
