<?php

namespace App\Models\Retail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchasePayments extends Model
{
    use HasFactory;

    protected $table = "retail_pos_purchase_payments";

    //protected $quarded = ['id','_token'];
    protected $guarded = ['id'];

public function payment(){
    
        return $this->BelongsTo('App\Models\AccountCodes','account_id');
    }
}
