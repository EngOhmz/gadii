<?php

namespace App\Models\Permit;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermitType extends Model
{
    use HasFactory;
    protected $table = "permit_type";

    protected  $guarded = ['id'];

        public function route(){

            return $this->belongsTo('App\Models\Route','route_id');
          }

          public function truck(){

            return $this->belongsTo('App\Models\Truck','truck_id');
          }

         
    
    public function user()
    {
        return $this->belongsTo('App\Models\user');
    }
}
