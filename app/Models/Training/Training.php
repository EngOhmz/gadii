<?php

namespace App\Models\Training;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    use HasFactory;

    protected $table = "tbl_training";

    protected $fillable = [
    'staff_id',
    'remarks',
   'training_name',
    'vendor_name',
    'start_date',
    'end_date',
    'status',
    'performance',
        'attachment',
        'training_cost',      
    'added_by'];
    

    public function  staff(){
    
        return $this->belongsTo('App\Models\user','staff_id');
      }

    


}
