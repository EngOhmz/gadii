<?php

namespace App\Models\CF;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class ShipmentTracking extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $table = "cf_shipment_tracking";
    
    public function addedByUser()
    {
        return $this->belongsTo(User::class, 'added_by');
    }
    
}