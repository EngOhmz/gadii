<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceAttachment extends Model
{
    use HasFactory;
    protected $table = "pos_invoice_attachment";
    protected  $guarded = ['id','_token'];


    public function invoice(){

        return $this->BelongsTo('App\Models\POS\Invoice','invoice_id');
    }


    
    
}
