<?php

namespace App\Models\Bar\POS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceHistory extends Model
{
    use HasFactory;

    protected $table = "store_pos_invoices_history";
    protected  $guarded = ['id','_token'];


    public function invoice(){

        return $this->BelongsTo('App\Models\Bar\POS\Invoice','invoice_id');
    }


    
    public function client(){
    
        return $this->BelongsTo('App\Models\Bar\POS\Client','client_id');
    }

 public function  store(){
    
        return $this->belongsTo('App\Models\Location','location');
      }
}
