<?php

namespace App\Models\Cotton;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Levy extends Model
{
    use HasFactory;

    protected $table = "levy";

  protected $guarded = ['id','_token'];
    
    public function user()
    {
        return $this->belongsTo('App\Models\user');
    }
public function chart()
    {
        return $this->belongsTo('App\Models\AccountCodes','account_id');
    }

    
}
