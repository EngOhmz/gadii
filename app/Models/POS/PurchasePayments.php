<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchasePayments extends Model
{
    use HasFactory;

    protected $table = "pos_purchase_payments";

    //protected $quarded = ['id','_token'];
    protected $guarded = ['id'];

 public function payment(){
    
        return $this->BelongsTo('App\Models\AccountCodes','account_id');
    }
    
    public function purchase(){
    
        return $this->BelongsTo('App\Models\POS\Purchase','purchase_id');
    }
}
