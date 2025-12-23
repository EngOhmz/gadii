<?php

namespace App\Models\Bar\POS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoodIssueItem extends Model
{
    use HasFactory;

    protected $table  = "store_pos_good_issues_items";

    protected $guarded = ['id'];

    public function store(){

        return $this->BelongsTo('App\Models\Location','location');
    }
    
    public function item(){

        return $this->BelongsTo('App\Models\Bar\POS\Items','item_id');
    }
    
}
