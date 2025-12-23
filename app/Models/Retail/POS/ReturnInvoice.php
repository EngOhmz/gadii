<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnInvoice extends Model
{
    use HasFactory;
    protected $table = "pos_return_invoices";
    protected  $guarded = ['id'];


    public function invoice(){

        return $this->BelongsTo('App\Models\POS\Invoice','invoice_id');
    }
    
    public function client(){
    
        return $this->BelongsTo('App\Models\Client','client_id');
    }
}
