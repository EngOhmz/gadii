<?php

namespace App\Models\Radio;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RadioItem extends Model
{
    use HasFactory;

    protected $table = "radio_items";

    protected $guarded = ['id','_token'];
    
    public function user()
    {
        return $this->belongsTo('App\Models\user');
    }

}
