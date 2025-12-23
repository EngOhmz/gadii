<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Insurance extends Model
{
    use HasFactory;
    protected $table = "tbl_insurances";

  protected $guarded = ['id','_token'];
    
      public function supplier()
    {
        return $this->belongsTo('App\Models\Supplier','broker_name');
    }
   
}