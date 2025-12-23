<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoodMovement extends Model
{
    use HasFactory;

    protected $table = "good_movements";

     protected $guarded = ['id'];
    
  public function approve(){

    //return $this->BelongsTo('App\Models\FieldStaff','staff');
   return $this->BelongsTo('App\Models\User','staff');
}

  public function source(){

        return $this->BelongsTo('App\Models\Location','source_store');
    }

   public function destination(){

        return $this->BelongsTo('App\Models\Location','destination_store');
    }
}
