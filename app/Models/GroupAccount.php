<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupAccount extends Model
{
    protected $table = "gl_account_group";
    
    protected $guarded = ['id','_token'];

    public $timestamps = false;
    
     public function classAccount()
    {
        return $this->BelongsTo('App\Models\ClassAccount', 'class');
    }
    
    
    public function chart()
    {
        return $this->hasOne(AccountCodes::class, 'id', 'account_id');
    }
       
     public function accountCodes()
    {
        return $this->hasMany(AccountCodes::class,'account_group','id');
    }


}
