<?php

namespace App\Models\Retail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceSerialHistory extends Model
{
    use HasFactory;
    protected $table = "retail_pos_invoice_serial_history";
    protected  $guarded = ['id','_token'];


    public function invoice(){

        return $this->hasMany('App\Models\Retail\InvoiceSerial','invoice_id');
    }
    
    public function client(){
    
        return $this->BelongsTo('App\Models\Retail\Client','client_id');
    }
}
