<?php

namespace App\Models\School;

use Illuminate\Database\Eloquent\Model;

class SchoolYear extends Model
{
   protected $table = 'school_years';

    protected $guarded = ['id','_token'];
}