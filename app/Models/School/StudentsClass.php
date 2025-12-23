<?php

namespace App\Models\School;

use Illuminate\Database\Eloquent\Model;

class StudentsClass extends Model
{
    protected $table = 'students_class';

    protected $guarded = ['id','_token'];
    
    public function level()
    {
        return $this->belongsTo(StudentLevel::class, 'level_id');
    }
}