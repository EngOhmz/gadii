<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sticker extends Model
{
    use HasFactory;

    protected $table = "stickers";

    protected $fillable = [      
        'issue_date',
        'office',
        'expire_date',
        'value',      
        'officer',
        'truck_id',
        'added_by'];
    
    public function user()
    {
        return $this->belongsTo('App\Models\user');
    }
}
