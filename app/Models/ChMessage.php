<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChMessage extends Model
{
    protected $table = "ch_messages";
    protected $fillable = ['attachment','body'];
}
