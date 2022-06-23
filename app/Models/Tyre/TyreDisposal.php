<?php

namespace App\Models\Tyre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TyreDisposal extends Model
{
    use HasFactory;

    protected $table = "tyre_disposals";

    protected $fillable = [
         'date',      
       'tyre_id',
        'staff',            
        'quantity',
        'location',
        'status',  
        'added_by'];
    
    public function user()
    {
         return $this->belongsTo('App\Models\FieldStaff','staff');
        //return $this->belongsTo('App\Models\User','staff');
    }

    public function tyre_staff(){

        return $this->belongsTo('App\Models\User','staff');
      }
    
     
      public function tyre_no(){
        return $this->belongsTo('App\Models\Tyre\Tyre','tyre_id');
    }

    public function  tyre_location(){
    
        return $this->belongsTo('App\Models\Location','location');
      }
}
