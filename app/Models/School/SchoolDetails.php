<?php

namespace App\Models\School;

use Illuminate\Database\Eloquent\Model;

class SchoolDetails extends Model
{
    protected $table = "school_fees_details";

      protected $guarded = ['id','_token'];

    

}
