<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipmentList extends Model
{
    use HasFactory;
    protected $table = 'equipment_list';

    protected  $guarded = ['id'];
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }


public function approve(){

    //return $this->BelongsTo('App\Models\FieldStaff','staff');
   return $this->BelongsTo('App\Models\User','staff');
}

public function truck(){

    return $this->BelongsTo('App\Models\Truck','truck_id');
}


   
}