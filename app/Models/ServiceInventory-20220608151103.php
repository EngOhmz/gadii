<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceInventory extends Model
{
    use HasFactory;

    protected $table = "service_inventory";

    protected $fillable = [
    'service_id',
     'item_name',         
    'order_no',      
    'added_by'];
    
    public function user()
    {
        return $this->belongsTo('App\Models\user');
    }
}
