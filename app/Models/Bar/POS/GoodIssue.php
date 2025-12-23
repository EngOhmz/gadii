<?php

namespace App\Models\Bar\POS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoodIssue extends Model
{
    use HasFactory;

    protected $table  = "store_pos_good_issues";

    protected $guarded = ['id'];



public function store(){

    return $this->BelongsTo('App\Models\Location','location');
}

public function approve(){

    return $this->BelongsTo('App\Models\FieldStaff','staff');
}

}
