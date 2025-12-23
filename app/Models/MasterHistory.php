<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class  MasterHistory extends Model
{
    use HasFactory;
    protected $table = "inventory_master_history";
    protected  $guarded = ['id','_token'];


    public function purchase(){

        return $this->belongsTo('App\Models\POS\Purchase','purchase_id');
    }
    
 
public function supplier(){

    return $this->BelongsTo('App\Models\Supplier','supplier_id');
}


public function invoice(){

        return $this->BelongsTo('App\Models\Invoice','invoice_id');
    }


    public function client(){
    
        return $this->BelongsTo('App\Models\Client','client_id');
    }
    
    public function staff(){
    
        return $this->BelongsTo('App\Models\User','staff_id');
    }
    
 public function  store(){
    
        return $this->belongsTo('App\Models\Location','location');
      }
      
      
       public function  list(){
    
        return $this->belongsTo('App\Models\InventoryList','serial_id');
      }
}
