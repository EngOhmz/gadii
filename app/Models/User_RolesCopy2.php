<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class User_RolesCopy2 extends Model
{
    //
    use HasFactory;
    
     protected $table = "user_role_copy2";
     
     protected  $guarded = ['id'];
     
      public function roles()
    {
        return $this->BelongsTo('App\Models\Role', 'role_id');
    }
    
    
      public function users()
    {
        return $this->BelongsTo('App\Models\User', 'user_id');
    }


}
