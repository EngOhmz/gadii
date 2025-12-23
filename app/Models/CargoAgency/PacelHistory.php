<?php

namespace App\Models\CargoAgency;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PacelHistory extends Model
{
    use HasFactory;
    
    protected $table = "tbl_cg_pacel_histories";
    protected $guarded = ['id'];


    public function customerPacel(){

        return $this->belogsTo('App\Models\Customer\Customer','pacel_id');
    }
}
