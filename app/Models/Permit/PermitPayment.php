<?php

namespace App\Models\Permit;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class  PermitPayment extends Model
{
    use HasFactory;

    protected $table = "permit_payments";

     protected  $guarded = ['id'];
    
    public function user()
    {
        return $this->belongsTo('App\Models\user');
    }
}
