<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TruckEquipment extends Model
{
    use HasFactory;

    protected $table  = "truck_equipment";

    protected $guarded = ['id'];




public function approve(){

    //return $this->BelongsTo('App\Models\FieldStaff','staff');
   return $this->BelongsTo('App\Models\User','staff');
}

public function truck(){

    return $this->BelongsTo('App\Models\Truck','truck_id');
}

}
