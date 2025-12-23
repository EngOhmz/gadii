<?php

namespace App\Models\CF;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShipmentPlanning extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $table = "cf_shipment_planning";
    
    
    public function supplier()
    {
        return $this->belongsTo(\App\Models\Supplier::class, 'supplier_id', 'id');
    }
    
}