<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProformaInvoiceAttachment extends Model
{
    use HasFactory;
    
    protected $table = 'proforma_invoice_attachments';
    
    protected $fillable = [
        'invoice_id',
        'file_path',
        'original_name',
        'file_type',
        'file_size'
    ];
    
    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }
}
