<?php

namespace App\Models\Pharmacy;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceSerialHistory extends Model
{
    use HasFactory;
    protected $table = "pharmacy_pos_invoice_serial_history";
    protected  $guarded = ['id','_token'];


    public function invoice(){

        return $this->hasMany('App\Models\Pharmacy\InvoiceSerial','invoice_id');
    }
    
    public function client(){
    
        return $this->BelongsTo('App\Models\Pharmacy\Client','client_id');
    }
}
