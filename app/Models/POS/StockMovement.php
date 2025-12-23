<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockMovement extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $table = "pos_stock_movement";

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
