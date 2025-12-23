<?php

namespace App\Models\Manufacturing\Blending;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pack extends Model
{
    use HasFactory;
    protected $table = 'packs';
    protected $fillable = ['size'];

    
}
