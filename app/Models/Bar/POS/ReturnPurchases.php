<?php

namespace App\Models\Bar\POS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnPurchases extends Model
{
    use HasFactory;

    protected $table = "store_pos_return_purchases";
    protected  $guarded = ['id'];


    public function purchase(){

        return $this->BelongsTo('App\Models\Bar\POS\Purchase','purchase_id');
    }
    
    public function supplier(){
    
        return $this->BelongsTo('App\Models\Bar\POS\Supplier','supplier_id');
    }
}
