<?php

namespace App\Models\CF;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $table = "cf_invoices";
    protected  $guarded = ['id'];


    public function invoice_items(){

        return $this->hasMany('App\Models\CF\InvoiceItems','id');
    }
    
    public function client(){
    
        return $this->BelongsTo('App\Models\Client','client_id');
    }
 public function  store(){
    
        return $this->belongsTo('App\Models\Location','location');
      }

public function assign(){

    return $this->BelongsTo('App\Models\User','user_agent');
}

public function project(){

    return $this->BelongsTo('App\Models\CF\Project','cf_id');
}
}
