<?php

namespace App\Models\School;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentPayment extends Model
{
    use HasFactory;

     protected $table = 'student_payments';

 protected $guarded = ['id','_token'];

  public function fee(){
    
        return $this->belongsTo('App\Models\School\School','fee_id');
      }

      public function student(){
    
        return $this->belongsTo('App\Models\School\Student','student_id');
      }

 public function user(){
    
        return $this->belongsTo('App\Models\User','added_by');
      }

}
