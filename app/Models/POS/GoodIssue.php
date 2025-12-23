<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoodIssue extends Model
{
    use HasFactory;

    protected $table  = "pos_good_issues";

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
