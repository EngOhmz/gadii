<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankReconciliation extends Model
{
    use HasFactory;

    protected $table = "bank_reconciliations";

     protected $guarded = ['id','_token'];

        public function chart()
    {
        return $this->hasOne(AccountCodes::class, 'id', 'account_id');
    }
}
