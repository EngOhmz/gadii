<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TruckEquipmentItem extends Model
{
    use HasFactory;

    protected $table  = "truck_equipment_items";

    protected $guarded = ['id'];

 
  public function item(){

        return $this->BelongsTo('App\Models\Equipment','item_id');
    }

  public function issue(){

        return $this->BelongsTo('App\Models\TruckEquipment','issue_id');
    }

public function truck(){

    return $this->BelongsTo('App\Models\Truck','truck_id');
}

public function approve(){

    //return $this->BelongsTo('App\Models\FieldStaff','staff');
   return $this->BelongsTo('App\Models\User','staff');
}


    
}
