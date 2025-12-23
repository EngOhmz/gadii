<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoodDisposalItem extends Model
{
    use HasFactory;

    protected $table  = "good_disposal_items";

    protected $guarded = ['id'];

    public function store(){

        return $this->BelongsTo('App\Models\Location','location');
    }
    
 public function item(){

        return $this->BelongsTo('App\Models\InventoryList','item_id');
    }
    
     public function brand(){

        return $this->BelongsTo('App\Models\Inventory','brand_id');
    }

  public function disposal(){

        return $this->BelongsTo('App\Models\GoodDisposal','disposal_id');
    }

public function truck(){

    return $this->BelongsTo('App\Models\Truck','truck_id');
}

    
}
