<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintainanceReport extends Model
{
    use HasFactory;

    protected $table = "maintainance_report";

  protected $guarded = [
         'id',      
       'token'];
    
    
    public function user()
    {
        return $this->belongsTo('App\Models\user');
    }
}
