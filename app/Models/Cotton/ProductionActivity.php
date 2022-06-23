<?php

namespace App\Models\Cotton;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductionActivity extends Model
{
    use HasFactory;
    protected $table = 'tbl_productionactivity';

    protected $fillable = ['production_id','lot_no','type','production_quantity','sales_quantity','status','added_by'];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    
      public function production()
    {
        return $this->belongsTo('App\Models\Cotton\Production');
    }

   
}