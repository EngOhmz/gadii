<?php

namespace App\Models\Project;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceHistory extends Model
{
    use HasFactory;
    protected $table = "tbl_project_invoices_history";
    protected  $guarded = ['id','_token'];


    public function invoice(){

        return $this->BelongsTo('App\Models\Project\Invoice','invoice_id');
    }


    
    public function client(){
    
        return $this->BelongsTo('App\Models\Client','client_id');
    }

 public function  store(){
    
        return $this->belongsTo('App\Models\Location','location');
      }
}
