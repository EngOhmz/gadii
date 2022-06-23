<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Monitoring_Solutions extends Model
{
    use HasFactory;

    protected $table = "tbl_monitoring_solutions";

    protected $fillable = ['monitoring_id','action','monitoring_id','chemical','result','status'];
    public function crops_monitoring()
    {
        return $this->belongsTo('App\Models\Crops_Monitoring','monitoring_id');
    }
    public function group()
    {
        return $this->belongsTo('App\Models\Group');
    }
   
}
