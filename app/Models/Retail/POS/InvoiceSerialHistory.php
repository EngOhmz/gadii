<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceSerialHistory extends Model
{
    use HasFactory;
    protected $table = "pos_serial_invoices_history";
    protected  $guarded = ['id','_token'];


    public function invoice(){

        return $this->hasMany('App\Models\POS\InvoiceSerial','invoice_id');
    }
    
    public function client(){
    
        return $this->BelongsTo('App\Models\Client','client_id');
    }
}
