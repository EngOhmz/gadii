<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    protected $table = 'deliveries';

    protected $guarded = [];

   public function invoice()
    {
        return $this->belongsTo(\App\Models\POS\Invoice\Invoice::class, 'invoice_id');
    }

    public function driver()
    {
        return $this->belongsTo(DeliveryDriver::class, 'driver_id');
    }
}
