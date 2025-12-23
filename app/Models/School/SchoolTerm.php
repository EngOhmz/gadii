<?php

namespace App\Models\School;

use Illuminate\Database\Eloquent\Model;

class SchoolTerm extends Model
{
    protected $table = 'school_terms';
    protected $guarded = ['id','_token'];

    public function schoolYear()
    {
        return $this->belongsTo(SchoolYear::class);
    }
}