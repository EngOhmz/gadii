<?php

namespace App\Models\Auditing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadsAuditing extends Model
{
    use HasFactory;

    protected $table = "tbl_leads_activities";

 
}
