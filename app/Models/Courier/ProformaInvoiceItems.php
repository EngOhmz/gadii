<?php

namespace App\Models\Courier;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProformaInvoiceItems extends Model
{
    use HasFactory;

    protected $table = "courier_proforma_items";
    protected  $guarded = ['id'];
}
