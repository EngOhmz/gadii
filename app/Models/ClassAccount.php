<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassAccount extends Model
{
    protected $table = "gl_account_class";
    
    protected $guarded = ['id','_token'];

    public $timestamps = false;
    
  public function groupAccount()
    {
        return $this->hasMany(GroupAccount::class, 'class', 'id');
    }
    
   
    
   public function accountType()
    {
        return $this->hasOne(AccountType::class, 'type', 'class_type');
    }

}
