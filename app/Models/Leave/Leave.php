<?php

namespace App\Models\Leave;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    use HasFactory;

    protected $table = "tbl_leave_application";

    protected $fillable = [
    'staff_id',
    'leave_category_id',
    'reason',
   'leave_type',
    'hours',
    'leave_start_date',
    'leave_end_date',
    'application_status',
    'application_date',
        'attachment',
        'comments',
        'approve_by',
    'added_by'];
    

    public function  staff(){
    
        return $this->belongsTo('App\Models\user','staff_id');
      }

      public function category(){
    
        return $this->belongsTo('App\Models\Leave\LeaveCategory','leave_category_id');
      }


}
