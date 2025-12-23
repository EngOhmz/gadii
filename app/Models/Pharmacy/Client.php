<?php

namespace App\Models\Pharmacy;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $table = 'pharmacy_clients';

    protected $fillable = ['user_id','name','address','phone','TIN','email'];
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

   
}