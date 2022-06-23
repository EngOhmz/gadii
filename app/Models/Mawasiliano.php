<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mawasiliano extends Model
{
    use HasFactory;
    protected $table = "mawasilianos";

    protected $fillable = ['name','email'];
}
