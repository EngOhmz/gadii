<?php

namespace App\Models\Tyre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TyreHistory extends Model
{
    use HasFactory;


    protected $table = "tyre_histories";

    protected  $guarded = ['id'];
    
    public function user()
    {
        return $this->belongsTo('App\Models\user');
    }
}
