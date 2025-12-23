<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoodIssueItem extends Model
{
    use HasFactory;

    protected $table  = "good_issue_items";

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

  public function issue(){

        return $this->BelongsTo('App\Models\GoodIssue','issue_id');
    }

public function truck(){

    return $this->BelongsTo('App\Models\Truck','truck_id');
}

    
}
