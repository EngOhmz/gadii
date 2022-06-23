<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedType extends Model
{
    use HasFactory;
    protected $table = "feed_type";


    protected $fillable = ['crop_name','feed_name','characteristics','added_by'];
    

    public function crop()
    {
        return $this->belongsTo('App\Models\Crops_type','crop_name');
    }

    
  
}