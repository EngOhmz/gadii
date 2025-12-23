<?php

namespace App\Models\CargoAgency\Customer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Nicolaslopezj\Searchable\SearchableTrait;

class Customer extends Model
{
    use HasFactory;

    protected $table = "tbl_cg_customers";
    protected $guarded = ['id'];
    

    use Notifiable;
    
    // use SearchableTrait;

    protected $searchable = [
    'columns' => [
    'customers.mteja'  => 10,
    'customers.mpokeaji'   => 10,
    'customers.created_at'   => 10,
    'customers.id'    => 10,
    ]
    ];


    public function customerPacel(){

        return $this->hasMany('App\Models\Customer\CustomerPacel','pacel_id');
    }
}
