<?php

namespace App\Models\School;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentHistory extends Model
{
    use HasFactory;

    protected $table = 'student_history';

     protected $guarded = ['id','_token'];

    public function schools(){

        return $this->belongsToMany('App\Models\School\School');
    }

}
