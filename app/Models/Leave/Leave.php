<?php

namespace App\Models\Leave;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    use HasFactory;

    protected $table = "tbl_leave_application";

    protected $guarded = ['id','_token'];

    public function  staff(){
    
        return $this->belongsTo('App\Models\User','staff_id');
      }

      public function category(){
    
        return $this->belongsTo('App\Models\Leave\LeaveCategory','leave_category_id');
      }


}
