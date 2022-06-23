<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Farming_process extends Model
{
    use HasFactory;

    protected $table = 'tbl_farming_processes';

    protected $fillable = ['process_name'];
    
    public function owner()
    {
        return $this->belongsTo('App\Models\Farmer','owner_id');
    }
    public function orders()
    {
        return $this->belongsTo('App\Models\order');
    }
}
