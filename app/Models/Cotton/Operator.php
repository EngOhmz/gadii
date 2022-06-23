<?php

namespace App\Models\Cotton;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operator extends Model
{
    use HasFactory;
    protected $table = 'operators';

    protected $fillable = ['user_id','name','address','phone','TIN','email','account_codes'];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

   
}