<?php

namespace App\Models\School;

use Illuminate\Database\Eloquent\Model;

class SchoolBranch extends Model
{
    protected $table = 'school_branches';

    protected $guarded = ['id','_token'];
}