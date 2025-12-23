<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoodReallocation extends Model
{
    use HasFactory;

    protected $table = "good_reallocations";

    protected $guarded = ['id'];
    
  public function approve(){

    return $this->BelongsTo('App\Models\FieldStaff','staff');
   //return $this->BelongsTo('App\Models\User','staff');
}

  public function source(){

        return $this->BelongsTo('App\Models\Truck','source_truck');
    }

   public function destination(){

        return $this->BelongsTo('App\Models\Truck','destination_truck');
    }
}
