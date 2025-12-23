<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceType extends Model
{
    use HasFactory;

    protected $table = "service_type";

   protected $guarded = [
         'id',      
       'token'];
    
    
    public function user()
    {
        return $this->belongsTo('App\Models\user');
    }
}
