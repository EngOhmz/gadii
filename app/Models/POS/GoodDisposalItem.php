<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoodDisposalItem extends Model
{
    use HasFactory;

    protected $table  = "pos_good_disposal_items";

    protected $guarded = ['id'];

    public function store(){

        return $this->BelongsTo('App\Models\Location','location');
    }
    
  public function item(){

        return $this->BelongsTo('App\Models\POS\Items','item_id');
    }

  public function disposal(){

        return $this->BelongsTo('App\Models\POS\GoodDisposal','disposal_id');
    }

public function truck(){

    return $this->BelongsTo('App\Models\Truck','truck_id');
}

    
}
