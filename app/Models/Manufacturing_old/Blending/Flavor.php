<?php

namespace App\Models\Manufacturing\Blending;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flavor extends Model
{
    use HasFactory;
    protected $table = 'flavors';
    protected $fillable = ['batch'];

    
}
