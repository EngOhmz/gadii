<?php

namespace App\Models\Goal_Tracking;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = "tbl_goal_task";

    protected $guarded = ['id'];
}
