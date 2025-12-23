<?php

namespace App\Models\Hotel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelItems extends Model
{
    use HasFactory;

    protected $table = "hotel_items";

  protected $guarded = ['id'];
  
   public function type(){
    
        return $this->BelongsTo('App\Models\Hotel\RoomType','room_type');
    }
  
}
