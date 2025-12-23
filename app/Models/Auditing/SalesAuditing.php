<?php

namespace App\Models\Auditing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesAuditing extends Model
{
    use HasFactory;

    protected $table = "pos_activities";


}
