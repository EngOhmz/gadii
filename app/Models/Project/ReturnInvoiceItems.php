<?php

namespace App\Models\Project;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnInvoiceItems extends Model
{
    use HasFactory;

    protected $table = "tbl_project_return_invoice_items";
    protected  $guarded = ['id'];
}
