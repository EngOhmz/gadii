<?php

namespace App\Models\Retail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceSerial extends Model
{
    use HasFactory;
    protected $table = "retail_pos_invoice_serial";
    protected  $guarded = ['id'];


    public function invoice_items(){

        return $this->hasMany('App\Models\Retail\InvoiceSerialItems','id');
    }
    
    public function client(){
    
        return $this->BelongsTo('App\Models\Retail\Client','client_id');
    }
  public function region(){
    
        return $this->BelongsTo('App\Models\Region','location');
    }
}
