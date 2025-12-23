<?php

namespace App\Models\School;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class StudentResult extends Model
{
    protected $table = 'student_results';

    protected $guarded = ['id','_token'];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function branchSubject()
    {
        return $this->belongsTo(BranchSubject::class);
    }

    public function examType()
    {
        return $this->belongsTo(ExamType::class);
    }

    public function studentsClass()
    {
        return $this->belongsTo(StudentsClass::class);
    }

    public function schoolStream()
    {
        return $this->belongsTo(SchoolStreams::class);
    }

    public function schoolTerm()
    {
        return $this->belongsTo(SchoolTerm::class);
    }

    public function schoolYear()
    {
        return $this->belongsTo(SchoolYear::class);
    }

    public function getGradeAttribute()
    {
        $score = $this->score;
        if ($score >= 80 && $score <= 100) {
            return 'A';
        } elseif ($score >= 60 && $score <= 79) {
            return 'B';
        } elseif ($score >= 49 && $score <= 59) {
            return 'C';
        } elseif ($score >= 35 && $score <= 48) {
            return 'D';
        } else {
            return 'E';
        }
    }
}