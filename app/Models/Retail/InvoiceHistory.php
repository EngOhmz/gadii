<?php

namespace App\Models\Retail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceHistory extends Model
{
    use HasFactory;
    protected $table = "retail_pos_invoices_history";
    protected  $guarded = ['id','_token'];


    public function invoice(){

        return $this->BelongsTo('App\Models\Retail\Invoice','invoice_id');
    }
    
    public function client(){
    
        return $this->BelongsTo('App\Models\Retail\Client','client_id');
    }

public function  store(){
    
        return $this->belongsTo('App\Models\Retail\Location','location');
      }

}
