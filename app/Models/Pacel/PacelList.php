<?php

namespace App\Models\Pacel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PacelList extends Model
{
    use HasFactory;

    protected $table = "pacel_lists";

    protected $fillable = [
    'name',
    'unit',
    'price',
    'quantity',
    'added_by'];
    
    public function user()
    {
        return $this->belongsTo('App\Models\user');
    }
}
