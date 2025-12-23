<?php

namespace App\Models\Restaurant\POS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnPurchases extends Model
{
    use HasFactory;

    protected $table = "restaurant_pos_return_purchases";
    protected  $guarded = ['id'];


    public function purchase(){

        return $this->BelongsTo('App\Models\Restaurant\POS\Purchase','purchase_id');
    }
    
    public function supplier(){
    
        return $this->BelongsTo('App\Models\Restaurant\POS\Supplier','supplier_id');
    }
}
