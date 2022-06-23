<?php

namespace App\Models\Cotton;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceSeedHistory extends Model
{
    use HasFactory;

 protected $table = "seed_invoice_history";

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
