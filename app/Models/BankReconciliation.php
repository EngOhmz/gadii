<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankReconciliation extends Model
{
    use HasFactory;

    protected $table = "bank_reconciliations";

    protected $fillable = [
        'transaction_type',
        'name',
        'debit',
        'date',
        'credit',
        'currency_code',
        'payment_id',
        'notes',   
        'account_id', 
        'added_by'];

        public function chart()
    {
        return $this->hasOne(ChartOfAccount::class, 'id', 'account_id');
    }
}
