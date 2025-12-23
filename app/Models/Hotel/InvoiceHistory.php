<?php

namespace App\Models\Hotel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceHistory extends Model
{
    use HasFactory;
    protected $table = "hotel_invoices_history";
    protected  $guarded = ['id','_token'];


    public function invoice(){

        return $this->BelongsTo('App\Models\Hotel\Invoice','invoice_id');
    }

public function store(){

    return $this->BelongsTo('App\Models\Hotel\Hotel','hotel_id');
}
    
    public function client(){
    
        return $this->BelongsTo('App\Models\Hotel\Client','client_id');
    }

 
}
