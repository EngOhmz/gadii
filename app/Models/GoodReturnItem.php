<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoodReturnItem extends Model
{
    use HasFactory;

    protected $table = "good_return_items";

    protected $fillable = [
          'item_id',
          'return_id',  
          'quantity',            
          'order_no',  
        'added_by'];
    
    public function user()
    {
        return $this->belongsTo('App\Models\user');
    }
}
