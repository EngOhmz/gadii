<?php

namespace App\Models\Goal_Tracking;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskActivity extends Model
{
    use HasFactory;

    protected $table = "tbl_goal_activities";

    protected $guarded = ['id'];
    

     
}
