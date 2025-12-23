<?php

namespace App\Models\School;

use Illuminate\Database\Eloquent\Model;

class BranchSubject extends Model
{
    protected $table = 'branch_subject';

    protected $guarded = ['id','_token'];

}