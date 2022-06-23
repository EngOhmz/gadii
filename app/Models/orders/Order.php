<?php

namespace App\Models\orders;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

  protected $table = "tbl_orders";
  protected $fillable = ['quantity','user_id','logistic_id','client_id','crop_type','warehouse_id','offered_amount','start_location','end_location','route_type','status'];

  public function crop_types(){

    return $this->belongsTo('App\Models\Crops_type','crop_type');
  }

  public function user(){

    return $this->belongsTo('App\Models\User','client_id');
  }

  public function warehouse(){
      return $this->belongsTo('App\Models\Warehouse','warehouse_id');
  }
}
