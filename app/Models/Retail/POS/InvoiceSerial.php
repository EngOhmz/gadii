<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceSerial extends Model
{
    use HasFactory;
    protected $table = "pos_serial_invoices";
    protected  $guarded = ['id'];


    public function invoice_items(){

        return $this->hasMany('App\Models\POS\InvoiceSerialItems','id');
    }
    
    public function client(){
    
        return $this->BelongsTo('App\Models\Client','client_id');
    }
}
