<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoodIssueItem extends Model
{
    use HasFactory;

    protected $table = "good_issue_items";

    protected $fillable = [
          'item_id',
          'issue_id',  
          'quantity',            
          'order_no',  
        'added_by'];
    
    public function user()
    {
        return $this->belongsTo('App\Models\user');
    }
}
