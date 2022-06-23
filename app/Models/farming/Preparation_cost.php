<?php

namespace App\Models\farming;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Preparation_cost extends Model
{
    use HasFactory;

    protected $table = "tbl_preparation_costs";

    protected $fillable = ['cost_name','cost','user_id'];
}
