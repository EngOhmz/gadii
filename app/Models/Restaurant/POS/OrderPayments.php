<?php

namespace App\Models\Restaurant\POS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderPayments extends Model
{
    use HasFactory;

    protected $table = "order_payments";

    protected $guarded = ['id'];

    public function payment(){
    
        return $this->BelongsTo('App\Models\AccountCodes','account_id');
    }
 public function user()
    {
        return $this->belongsTo('App\Models\User','added_by');
    }
}
