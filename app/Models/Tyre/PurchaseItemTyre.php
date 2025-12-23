<?php

namespace App\Models\Tyre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseItemTyre extends Model
{
    use HasFactory;
    protected $table = "purchase_item_tyres";

    protected  $guarded = ['id'];
    
    public function user()
    {
        return $this->belongsTo('App\Models\user');
    }
}
