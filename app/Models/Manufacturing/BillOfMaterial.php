<?php

namespace App\Models\Manufacturing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillOfMaterial extends Model
{
    use HasFactory;

    protected $table = "bill_of_materials";

    protected $fillable = [
    'reference_no',
    'manufactured_item',
    'work_centre',
    'status',
    'added_by'];
    
  public function user()
    {
        return $this->belongsTo('App\Models\User','added_by');
    }


}
