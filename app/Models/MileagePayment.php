<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class  MileagePayment extends Model
{
    use HasFactory;

    protected $table = "millage_payments";

    protected $fillable = [
    'movement_id',
'mileage_id',
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
