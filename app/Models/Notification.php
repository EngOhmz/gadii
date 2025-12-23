<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = "tbl_notifications";

      protected $guarded = ['id'];

      
   public function from()
    {
        return $this->belongs('App\Models\User', 'from_user_id');
    }

public function to()
    {
        return $this->BelongsTo('App\Models\User', 'to_user_id');
    }

}
