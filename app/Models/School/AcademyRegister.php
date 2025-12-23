<?php

namespace App\Models\School;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class AcademyRegister extends Model
{
    protected $table = 'academy_registers';

    protected $guarded = ['id','_token'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function branchSubject()
    {
        return $this->belongsTo(StudentSubject::class);
    }

    public function studentsClass()
    {
        return $this->belongsTo(StudentsClass::class);
    }

    public function schoolStream()
    {
        return $this->belongsTo(SchoolStreams::class);
    }

    public function examType()
    {
        return $this->belongsTo(ExamType::class);
    }

    public function schoolYear()
    {
        return $this->belongsTo(SchoolYear::class);
    }

    public function schoolTerm()
    {
        return $this->belongsTo(SchoolTerm::class);
    }
}