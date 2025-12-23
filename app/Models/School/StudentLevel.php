<?php

namespace App\Models\School;

use Illuminate\Database\Eloquent\Model;

class StudentLevel extends Model
{
    protected $table = 'student_levels';

    protected $guarded = ['id','_token'];
}