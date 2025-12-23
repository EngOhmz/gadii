<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoodDisposal extends Model
{
    use HasFactory;

    protected $table  = "good_disposals";

    protected $guarded = ['id'];



public function store(){

    return $this->BelongsTo('App\Models\Location','location');
}

public function approve(){

    //return $this->BelongsTo('App\Models\FieldStaff','staff');
   return $this->BelongsTo('App\Models\User','staff');
}

public function truck(){

    return $this->BelongsTo('App\Models\Truck','truck_id');
}

}
