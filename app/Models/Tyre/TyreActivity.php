<?php

namespace App\Models\Tyre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TyreActivity extends Model
{
    use HasFactory;

    use HasFactory;

    protected $table = "tyre_activities";

    protected $fillable = [
      'module_id',
      'module',
    'date',
    'activity',  
    'added_by'];
    
   
    public function user(){
    
        return $this->belongsTo('App\Models\User','added_by');
      }

      public function tyre_purchase(){
    
        return $this->belongsTo(' App\Models\Tyre\PurchaseTyre','purchase_id');
      }
}
