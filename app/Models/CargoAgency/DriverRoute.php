<?php

namespace App\Models\CargoAgency;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverRoute extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'tbl_cg_driver_routes';


    public function car(){

        return $this->belongsTo('App\Models\Management\Car','car_id');
    }

    public function driver(){

        return $this->belongsTo('App\Models\Management\Driver','driver_id');
    }

    public function user(){

        return $this->belongsTo('App\Models\User','user_id');
    }
}
