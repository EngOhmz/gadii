<?php

namespace App\Models\Bar\POS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $table = "store_pos_invoices";
    protected  $guarded = ['id'];

    
    public function invoice_items(){

        return $this->hasMany('App\Models\Bar\POS\InvoiceItems','id');
    }
    
    public function client(){
    
        return $this->BelongsTo('App\Models\Bar\POS\Client','client_id');
    }
}
