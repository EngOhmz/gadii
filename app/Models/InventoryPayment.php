<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryPayment extends Model
{
    use HasFactory;

    protected $table = "inventory_payments";

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
