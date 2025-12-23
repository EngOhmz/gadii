<?php

namespace App\Models\Manufacturing\Blending;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blending extends Model
{
    use HasFactory;
    protected $table = 'tbl_blendings';
    protected $guarded = ['id'];
    
    public function alcohols(){
        
        return $this->belongsTo('App\Models\Manufacturing\Blending\Alcohol','alcohol_id');
    }
       public function flavours(){
        
        return $this->belongsTo('App\Models\Manufacturing\Blending\Flavor','flavour_id');
    }
       public function lines(){
        
        return $this->belongsTo('App\Models\Manufacturing\Blending\Line','line_id');
    }
       public function packs(){
        
        return $this->belongsTo('App\Models\Manufacturing\Blending\Pack','pack_id');
    }
       public function tanks(){
        
      
       return $this->belongsTo('App\Models\Manufacturing\Blending\Tank','tank_id');
    }   
    
    public function types(){
        
        return $this->belongsTo('App\Models\Manufacturing\Blending\Type','product_id');
    }


    
}
