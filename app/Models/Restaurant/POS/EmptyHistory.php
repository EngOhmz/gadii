<?php

namespace App\Models\Restaurant\POS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmptyHistory extends Model
{
    use HasFactory;

    protected $table = "restaurant_pos_empty_history";

    protected $guarded = ['id','_token'];

    
    public function purchase(){

        return $this->belongsTo('App\Models\Restaurant\POS\Purchase','purchase_id');
    }

    public function invoice(){

        return $this->BelongsTo('App\Models\Restaurant\POS\Invoice','invoice_id');
    }
}
