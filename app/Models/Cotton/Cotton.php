<?php

namespace App\Models\Cotton;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cotton extends Model
{
    use HasFactory;

    protected $table = "tbl_cotton";

    protected $fillable = [
    'name',
    'unit',
    'quantity',
    'price',
    'added_by'];
    
    public function user()
    {
        return $this->belongsTo('App\Models\user');
    }


    
}
