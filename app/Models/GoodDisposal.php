<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoodDisposal extends Model
{
    use HasFactory;

    protected $table = "good_disposals";

    protected $fillable = [
         'date',      
       'item_id',
        'staff',            
        'quantity', 
       'status',
        'added_by'];
    
    public function user()
    {
        return $this->belongsTo('App\Models\user');
    }
}
