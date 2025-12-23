<?php

namespace App\Models\Radio;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RadioDueList extends Model
{
    use HasFactory;

    protected $table = "radio_due_list";

      protected $guarded = ['id','_token'];

   



      
}
