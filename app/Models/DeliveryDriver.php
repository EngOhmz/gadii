<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryDriver extends Model
{
    protected $table = 'delivery_drivers';

    protected $guarded = [];

    public function deliveries()
    {
        return $this->hasMany(Delivery::class, 'driver_id');
    }
}
