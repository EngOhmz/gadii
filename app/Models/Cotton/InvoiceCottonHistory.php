<?php

namespace App\Models\Cotton;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class  InvoiceCottonHistory extends Model
{
    use HasFactory;

 protected $table = "cotton_invoice_history";

     protected $guarded = ['id','_token'];
    
    public function user()
    {
        return $this->belongsTo('App\Models\user');
    }

 public function center()
    {
        return $this->belongsTo('App\Models\Cotton\CollectionCenter','location');
    }
}
