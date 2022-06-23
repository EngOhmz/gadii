<?php

namespace App\Models\Tyre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TyreHistory extends Model
{
    use HasFactory;

    use HasFactory;

    protected $table = "tyre_histories";

    protected $fillable = [
    'purchase_id',
    'items_id', 
    'quantity',                 
     'supplier_id',
    'purchase_date', 
     'location',  
    'added_by'];
    
    public function user()
    {
        return $this->belongsTo('App\Models\user');
    }
}
