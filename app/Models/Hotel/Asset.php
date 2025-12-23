<?php

namespace App\Models\Hotel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

    protected $table = "hotel_assets";

  protected $guarded = ['id'];
  
  
  public function nation(){
    
        return $this->BelongsTo('App\Models\Nationality','nationality');
    }
}
