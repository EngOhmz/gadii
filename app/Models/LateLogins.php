<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LateLogins extends Model
{
    use HasFactory;
    
    protected $table = 'late_logins_clients';

    protected  $guarded = ['id'];
    
   

   
}