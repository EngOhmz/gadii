<?php

namespace App\Models\School;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolPayment extends Model
{
    use HasFactory;

    protected $table = 'school_payments';

 
   protected $guarded = ['id','_token'];

  public function payment(){
    
        return $this->belongsTo('App\Models\School\StudentPayment','payment_id');
      }

      public function student(){
    
        return $this->belongsTo('App\Models\School\Student','student_id');
      }

 public function user(){
    
        return $this->belongsTo('App\Models\User','added_by');
      }
public function chart()
    {
       return $this->belongsTo('App\Models\AccountCodes', 'bank_id');
    }

}
