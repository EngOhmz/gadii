<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;
    protected $table = "drivers";

 protected $fillable = ['driver_name','licence','address','referee','mobile_no','experience','profile','added_by','driver_status', 'status','type','available'];
    
    public function user()
    {
        return $this->belongsTo('App\Models\user');
    }
}
