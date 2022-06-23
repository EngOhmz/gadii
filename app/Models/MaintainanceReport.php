<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintainanceReport extends Model
{
    use HasFactory;

    protected $table = "maintainance_report";

    protected $fillable = [
    'maintainance_id',
     'item_name',         
    'order_no',      
    'added_by'];
    
    public function user()
    {
        return $this->belongsTo('App\Models\user');
    }
}
