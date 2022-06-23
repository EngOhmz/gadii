<?php

namespace App\Models\orders;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cost_function extends Model
{
    use HasFactory;

    protected $table = 'tbl_cost_functions';


    protected $fillable = [
        'price',
        'name',
        'description',
        'unit',
        'user_id',
    ];
}
