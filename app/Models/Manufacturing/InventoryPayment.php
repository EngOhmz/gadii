<?php

namespace App\Models\Manufacturing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryPayment extends Model
{
    use HasFactory;

    protected $table = "manufacturing_inventory_payments";

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
