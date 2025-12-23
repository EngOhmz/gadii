<?php

namespace App\Models\School;

use Illuminate\Database\Eloquent\Model;

class ExamType extends Model
{
    protected $table = 'exam_types';

    protected $guarded = ['id','_token'];
    
    public function level()
    {
        return $this->belongsTo(StudentLevel::class, 'level_id');
    }
}