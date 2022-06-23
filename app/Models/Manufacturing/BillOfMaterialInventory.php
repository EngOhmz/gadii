<?php

namespace App\Models\Manufacturing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillOfMaterialInventory extends Model
{
    use HasFactory;

    protected $table = "bill_of_material_inventory";

    protected $fillable = [
    'bill_of_material_id',
    'item_name',
    'description',
    'source_location',
    'source_location',
    'quantity',
    'total_cost',
    'unit',        
    'items_id',           
    'price',      
    'added_by'];
    
    public function user()
    {
        return $this->belongsTo('App\Models\user');
    }
}
