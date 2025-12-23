<?php

namespace App\Models\CargoAgency\Management;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;

    protected $table = "tbl_cg_drivers";

    protected $fillable = ['name','phone', 'status', 'assigned_date'];

    public function car(){
        return $this->hasOne('App\Models\Management\Car');
    }
    
}
