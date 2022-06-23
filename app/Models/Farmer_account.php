<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Farmer_account extends Model
{
    use HasFactory;
    protected $table = "tbl_farmer_accounts";

    protected $fillable = ['farmer_id','warehouse_id','crops_type_id','total_quantity'];
    
     public function farmer()
    {
        return $this->belongsTo('App\Models\Farmer','farmer_id');
    }
    
      public function crops_type()
    {
        return $this->belongsTo('App\Models\Crops_type','crops_type_id');
    }
    public function warehouse()
    {
        return $this->belongsTo('App\Models\Warehouse','warehouse_id');
    }
  
}