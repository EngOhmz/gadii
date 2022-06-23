<?php

namespace App\Models\Cotton;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductionList extends Model
{
    use HasFactory;
    protected $table = 'tbl_productionlist';

    protected $fillable = ['production_id','bale','status','added_by'];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    
      public function production()
    {
        return $this->belongsTo('App\Models\Cotton\Production');
    }

   
}