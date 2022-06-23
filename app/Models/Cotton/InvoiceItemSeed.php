<?php

namespace App\Models\Cotton;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceItemSeed extends Model
{
    use HasFactory;

        protected $table = "seed_invoice_item";

     protected $guarded = ['id','_token'];

  
    public function user()
    {
        return $this->belongsTo('App\Models\user');
    }
}
