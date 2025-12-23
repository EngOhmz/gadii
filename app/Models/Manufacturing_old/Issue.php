<?php

namespace App\Models\Manufacturing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
    use HasFactory;

    protected $table = "work_order_issue";

    protected $fillable = [
    'reference_no',
    'issue_date',
    'location',
     'work_centre',
      'type',
       'notes',
    'added_by'];
    
  public function user()
    {
        return $this->belongsTo('App\Models\User','added_by');
    }


}
