<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountType extends Model
{
    protected $table = "gl_account_type";

    public $timestamps = false;
    
  public function classAccount()
    {
        return $this->hasMany(ClassAccount::class, 'class_type', 'type');
    }

}