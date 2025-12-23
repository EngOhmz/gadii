<?php

namespace App\Models\School;

use Illuminate\Database\Eloquent\Model;

class SchoolStreams extends Model
{
    protected $table = 'school_streams';

    protected $guarded = ['id','_token'];
    
    public function class()
    {
        return $this->belongsTo(StudentsClass::class, 'class_id');
    }

    public function level()
    {
        return $this->belongsTo(StudentLevel::class, 'level_id');
    }
}