<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $table = "tbl_items";
    
    public function c(){

        return $this->BelongsTo('App\Models\POS\Color','color');
    }
    
    
     public function s(){

        return $this->BelongsTo('App\Models\POS\Size','size');
    }
    
     public function cat(){

        return $this->BelongsTo('App\Models\POS\Category','category_id');
    }
}
