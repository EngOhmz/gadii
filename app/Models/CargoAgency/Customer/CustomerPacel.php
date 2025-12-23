<?php

namespace App\Models\CargoAgency\Customer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class CustomerPacel extends Model
{
    use HasFactory;

 
    protected $table = "tbl_cg_customer_pacels";
    protected $guarded = ['id'];

    public function customerPacel(){

        return $this->belogsTo('App\Models\CargoAgency\Customer\Customer','pacel_id');
    }
}
