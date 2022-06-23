<?php

namespace App\Models\Cotton;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Costants extends Model
{
    use HasFactory;

    protected $table = "tbl_costants";

    protected $fillable = [
    'cotton',
    'seeds',
    'raw_cotton',
    'dust',
    'added_by'];
    
    public function user()
    {
        return $this->belongsTo('App\Models\user');
    }


    
}
