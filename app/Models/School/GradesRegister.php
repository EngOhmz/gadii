<?php

namespace App\Models\School;

use Illuminate\Database\Eloquent\Model;

class GradesRegister extends Model
{
    protected $table = 'grades_register';

    protected $guarded = ['id','_token'];
}