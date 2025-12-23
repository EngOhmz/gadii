<?php

namespace App\Models\Restaurant\POS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $table = "restaurant_pos_invoices";
    protected  $guarded = ['id'];

    
    public function invoice_items(){

        return $this->hasMany('App\Models\Restaurant\POS\InvoiceItems','id');
    }
    
    public function client(){
    
        return $this->BelongsTo('App\Models\Restaurant\POS\Client','client_id');
    }
}
