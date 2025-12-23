<?php

namespace App\Models\Budget;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    use HasFactory;

    protected $table  = "tbl_budget";

    protected $guarded = ['id'];

  public function year(){

        return $this->BelongsTo('App\Models\Fiscal','year_id');
    }



}
