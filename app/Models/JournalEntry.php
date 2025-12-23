<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JournalEntry extends Model
{
    protected $table = "journal_entries";

    protected $guarded = ['id','_token'];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function chart()
    {
        return $this->hasOne(AccountCodes::class, 'id', 'account_id');
    }

    public function valuations()
    {
        return $this->hasMany(AssetValuation::class, 'asset_id', 'id')->orderBy('date', 'desc');
    }
    
    public function accountCodes()
    {
        return $this->hasOne(AccountCodes::class, 'account_id', 'account_id');
    }
public function borrower()
    {
        return $this->hasOne(Borrower::class, 'id', 'borrower_id');
    }
}
