<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grocery extends Model
{
    use HasFactory;
    protected $table = 'groceries';
    protected $fillable = ['id','user_id','name','email','phone','addess'];
}
