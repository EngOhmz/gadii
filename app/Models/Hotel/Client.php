<?php

namespace App\Models\Hotel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $table = "hotel_clients";

  protected $guarded = ['id'];
  
  
  public function nation(){
    
        return $this->BelongsTo('App\Models\Nationality','nationality');
    }
}
