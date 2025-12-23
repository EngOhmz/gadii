<?php

namespace App\Models\Hotel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booked extends Model
{
    use HasFactory;
    protected $table = "hotel_booked_rooms";
    protected  $guarded = ['id','_token'];


    public function invoice(){

        return $this->BelongsTo('App\Models\Hotel\Invoice','invoice_id');
    }


    
    public function room(){
    
        return $this->BelongsTo('App\Models\Hotel\HotelItems','room_id');
    }

 
}
