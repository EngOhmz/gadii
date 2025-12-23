<?php

namespace App\Models\Tyre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TyrePayment extends Model
{
    use HasFactory;

    protected $table = "tyre_payments";

    protected  $guarded = ['id'];
    
     public function user()
    
    {
        return $this->belongsTo('App\Models\user');
    }
    
     public function payment(){
    
        return $this->BelongsTo('App\Models\AccountCodes','account_id');
    }
    
    public function purchase(){
    
        return $this->BelongsTo('App\Models\Tyre\PurchaseTyre','purchase_id');
    }
}
