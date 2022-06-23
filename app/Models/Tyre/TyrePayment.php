<?php

namespace App\Models\Tyre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TyrePayment extends Model
{
    use HasFactory;

    protected $table = "tyre_payments";

    protected $fillable = [
    'purchase_id',
    'trans_id',
    'amount',
    'date',
    'payment_method',
    'notes',   
    'account_id', 
    'added_by'];
    
    public function user()
    {
        return $this->belongsTo('App\Models\user');
    }
}
