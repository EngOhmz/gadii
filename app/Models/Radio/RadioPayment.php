<?php

namespace App\Models\Radio;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RadioPayment extends Model
{
    use HasFactory;

    protected $table = "radio_payments";

    protected $guarded = ['id','_token'];
    
    public function user()
    {
        return $this->belongsTo('App\Models\user');
    }

public function bank(){
    
        return $this->belongsTo('App\Models\AccountCodes','account_id');
      }

}
