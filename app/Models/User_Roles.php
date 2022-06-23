<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User_Roles extends Model
{
    //
     protected $table = "users_roles";
     
     protected $filable = ['role_id','user_id'];






}
