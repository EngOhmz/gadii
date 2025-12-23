<?php

namespace App\Models\Hotel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $table = "hotel_invoices";
    protected  $guarded = ['id'];


    public function invoice_items(){

        return $this->hasMany('App\Models\Hotel\InvoiceItems','id');
    }
    
    public function client(){
    
        return $this->BelongsTo('App\Models\Hotel\Client','client_id');
    }


public function assign(){

    return $this->BelongsTo('App\Models\User','user_agent');
}


public function store(){

    return $this->BelongsTo('App\Models\Hotel\Hotel','hotel_id');
}


}
