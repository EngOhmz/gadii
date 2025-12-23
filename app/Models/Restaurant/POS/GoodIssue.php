<?php

namespace App\Models\Restaurant\POS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoodIssue extends Model
{
    use HasFactory;

    protected $table  = "restaurant_pos_good_issues";

    protected $guarded = ['id'];



public function store(){

    return $this->BelongsTo('App\Models\Location','location');
}

public function main(){

    return $this->BelongsTo('App\Models\Location','start');
}

public function approve(){

    return $this->BelongsTo('App\Models\User','staff');
}

}
