<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassAccount extends Model
{
    protected $table = "gl_account_class";

    public $timestamps = false;
    
  public function groupAccount()
    {
        return $this->hasMany(GroupAccount::class, 'class', 'class_name');
    }
    
   public function accountType()
    {
        return $this->hasOne(AccountType::class, 'type', 'class_type');
    }

}
