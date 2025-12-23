<?php

namespace App\Models\Retail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $table = 'retail_clients';

    protected  $guarded = ['id'];
    
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

   
}