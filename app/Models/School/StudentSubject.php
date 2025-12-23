<?php

namespace App\Models\School;

use Illuminate\Database\Eloquent\Model;

use App\Models\User;

class StudentSubject extends Model
{
    protected $table = 'student_subjects';

    protected $guarded = ['id','_token'];
    
    public function teachers()
    {
        return $this->belongsToMany(User::class, 'teacher_subject', 'subject_id', 'teacher_id')
                    ->withTimestamps();
    }
    
    public function level()
    {
        return $this->belongsTo(StudentLevel::class, 'level_id');
    }
    
}