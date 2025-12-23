<?php

namespace App\Models\Payroll;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollActivity extends Model
{
    use HasFactory;

    protected $table = "tbl_payroll_activities";

     protected $guarded = ['id','_token'];
    
   
    public function user(){
    
        return $this->belongsTo('App\Models\User','user_id');
      }

     
}
