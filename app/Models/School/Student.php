<?php

namespace App\Models\School;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $table = 'students';

     protected $guarded = ['id','_token'];

    public function schools(){

        return $this->belongsToMany('App\Models\School\School');
    }
    
    public function level()
    {
        return $this->belongsTo(StudentLevel::class, 'school_level_id', 'id');
    }

    /**
     * Relationship to StudentsClass
     */
    public function class()
    {
        return $this->belongsTo(StudentsClass::class, 'class_id', 'id');
    }

    public function stream()
    {
        return $this->belongsTo(SchoolStreams::class, 'stream_id');
    }

    public function branch()
    {
        return $this->belongsTo(SchoolBranch::class, 'branch_id');
    }

}
