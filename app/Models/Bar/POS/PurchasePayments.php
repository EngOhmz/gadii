<?php

namespace App\Models\Bar\POS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchasePayments extends Model
{
    use HasFactory;

    protected $table = "store_pos_purchase_payments";

    protected $guarded = ['id'];

  public function payment(){
    
        return $this->BelongsTo('App\Models\AccountCodes','account_id');
    }
}
