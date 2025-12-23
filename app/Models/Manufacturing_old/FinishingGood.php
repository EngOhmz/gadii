<?php

namespace App\Models\Manufacturing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinishingGood extends Model
{
    use HasFactory; 
    

    protected $table = "tbl_finishing_goods";
    
    protected $guarded = ['id'];


    
  public function blending()
    {
        return $this->belongsTo('App\Models\Manufacturing\Blendiing\Blending','blending_id');
    }
    
      public function packs(){
        
        return $this->belongsTo('App\Models\Manufacturing\Blending\Pack','pack_size_id');
    }
       public function lines(){
        
        return $this->belongsTo('App\Models\Manufacturing\Blending\Line','line_id');
    }
    
      public function product(){
        
        return $this->belongsTo('App\Models\Manufacturing\Blending\Type','product_id');
    }


}
