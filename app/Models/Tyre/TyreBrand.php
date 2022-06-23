<?php

namespace App\Models\Tyre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TyreBrand extends Model
{
    use HasFactory;

    protected $table = "tyre_brands";

    protected $fillable = [
         'manufacturer',      
       'brand',
        'size',            
        'price', 
        'quantity',            
        'unit',
        'added_by'];
    
    public function user()
    {
        return $this->belongsTo('App\Models\user');
    }
}
