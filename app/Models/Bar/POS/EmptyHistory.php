<?php

namespace App\Models\Bar\POS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmptyHistory extends Model
{
    use HasFactory;

    protected $table = "store_pos_empty_history";

    protected $guarded = ['id','_token'];

    
    public function purchase(){

        return $this->belongsTo('App\Models\Bar\POS\Purchase','purchase_id');
    }

    public function invoice(){

        return $this->BelongsTo('App\Models\Bar\POS\Invoice','invoice_id');
    }
}
