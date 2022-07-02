<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $table = "pos_invoices";
    protected  $guarded = ['id'];


    public function invoice_items(){

        return $this->hasMany('App\Models\POS\InvoiceItems','id');
    }
    
    public function client(){
    
        return $this->BelongsTo('App\Models\Client','client_id');
    }
}
