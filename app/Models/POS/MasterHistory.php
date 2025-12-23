<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\POS\Items;
use App\Models\Location;

class  MasterHistory extends Model
{
    use HasFactory;
    protected $table = "pos_master_history";
    protected  $guarded = ['id','_token'];


    public function purchase(){

        return $this->belongsTo('App\Models\POS\Purchase','purchase_id');
    }
    
 
public function supplier(){

    return $this->BelongsTo('App\Models\Supplier','supplier_id');
}


public function invoice(){

        return $this->BelongsTo('App\Models\POS\Invoice','invoice_id');
    }


    public function client(){
    
        return $this->BelongsTo('App\Models\Client','client_id');
    }
    
    public function staff(){
    
        return $this->BelongsTo('App\Models\User','staff_id');
    }
    
    public function item()
    {
        return $this->belongsTo(Items::class, 'item_id', 'id'); // Fix relationship
    }
    
   public function location()
{
    return $this->belongsTo(Location::class, 'location'); // 'location' is the foreign key in MasterHistory
}

    
    public function  store(){
    
        return $this->belongsTo('App\Models\Location','location');
      }
}
