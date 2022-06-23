<?php

namespace App\Models\Leave;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveCategory extends Model
{
    use HasFactory;

    protected $table = "tbl_leave_category";

    protected $fillable = [
    'leave_category',
    'added_by'];
    
    public function user()
    {
        return $this->belongsTo('App\Models\user');
    }
}
