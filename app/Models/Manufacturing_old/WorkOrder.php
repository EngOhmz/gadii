<?php

namespace App\Models\Manufacturing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkOrder extends Model
{
    use HasFactory;

    protected $table = "work_orders";
    
    protected $guarded = ['id'];

    // protected $fillable = [
    // 'reference_no',
    //  'type',
    //   'iten_id',
    //   'destination_location',
    //  'quantity',
    //   'date',
    //     'labour_cost',
    //  'overhead_cost',
    //   'description',
    // 'added_by'];
    
    public function user()
    {
        return $this->belongsTo('App\Models\user');
    }
    
    // public function user()
    // {
    //     return $this->hasMany('App\Models\User','id', 'responsible_id');
    // }


 public function item(){
        
        return $this->belongsTo('App\Models\POS\Items','product_name');
    }

 public function assign()
     {
       return $this->belongsTo('App\Models\User', 'responsible_id');
     }


}
