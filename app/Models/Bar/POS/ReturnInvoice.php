<?php

namespace App\Models\Bar\POS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnInvoice extends Model
{
    use HasFactory;

    protected $table = "store_pos_return_invoices";
    protected  $guarded = ['id'];


    public function invoice(){

        return $this->BelongsTo('App\Models\Bar\POS\Invoice','invoice_id');
    }
    
    public function client(){
    
        return $this->BelongsTo('App\Models\Bar\POS\Client','client_id');
    }
}
