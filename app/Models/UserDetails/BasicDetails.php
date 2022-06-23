<?php

namespace App\Models\UserDetails;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BasicDetails extends Model
{
    use HasFactory;
    protected $table = "basic_details";
    protected $fillable = ['emp_id','user_name','join_date','mobile','birth_date','father_name','email','full_name','gender','marital_status','mother_name','phone','departments_id','national_id','user_id'];

    public function user(){
        return $this->belongsTo('App/Models/User','user_id');
    }
}    

