<?php

namespace App\Models\Retail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnInvoice extends Model
{
    use HasFactory;
    protected $table = "retail_pos_return_invoices";
    protected  $guarded = ['id'];


    public function invoice(){

        return $this->BelongsTo('App\Models\Retail\Invoice','invoice_id');
    }
    
    public function client(){
    
        return $this->BelongsTo('App\Models\Retail\Client','client_id');
    }
}
