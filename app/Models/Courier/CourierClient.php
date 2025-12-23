<?php

namespace App\Models\Courier;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourierClient extends Model
{
    use HasFactory;
    protected $table = 'courier_clients';

  protected $guarded = ['id','_token'];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

   
}