<?php

namespace App\Models\Leads;

use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    protected $table = "tbl_reminder";

    protected $guarded = ['id'];
    
}