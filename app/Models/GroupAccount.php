<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupAccount extends Model
{
    protected $table = "gl_account_group";

    public $timestamps = false;
    
     public function classAccount()
    {
        return $this->hasOne(ClassAccount::class, 'class_name', 'class');
    }
    
       
     public function accountCodes()
    {
        return $this->hasMany(AccountCodes::class,'account_group','name');
    }


}
