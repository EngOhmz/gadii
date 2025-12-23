<?php

namespace App\Models\UserDetails;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DueDate extends Model
{
    use HasFactory;
    protected $table = "user_due";
     protected $guarded = ['id'];
}
