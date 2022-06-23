<?php

namespace App\Models\farming;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Weeding extends Model
{
    use HasFactory;

    protected $table = "tbl_weedings";

    protected $fillable = [
'seasson_id',
    'process',
'method',
   'name',
'effect',
'chemical_status',
   'weed_cost',
   'acre',
        'cost',
       'chemical',
        'total_cost',     
        'added_by'];

    public function farm_gap(){

        return $this->belongsTo('App\Models\Farming_process','process');
    }


}
