<?php

namespace App\Models\Cotton;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CottonHistory extends Model
{
    use HasFactory;

    protected $table = "cotton_history";

    protected $fillable = [
    'purchase_id',
      'reference',
    'items_id', 
    'quantity',  
    'due_quantity',                 
     'supplier_id',
    'purchase_date', 
     'location',  
    'price',  
    'added_by'];
    
    public function user()
    {
        return $this->belongsTo('App\Models\user');
    }

 public function center()
    {
        return $this->belongsTo('App\Models\Cotton\CollectionCenter','location');
    }
}
