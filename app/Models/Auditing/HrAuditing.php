<?php

namespace App\Models\Auditing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HrAuditing extends Model
{
    use HasFactory;

    protected $table = "tbl_payroll_activities";
    
    public function user()
    {
        return $this->belongsTo('App\Models\user');
    }
}
