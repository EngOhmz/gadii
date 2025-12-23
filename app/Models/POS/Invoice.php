<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Invoice extends Model
{
    use HasFactory;
    protected $table = "pos_invoices";
    protected  $guarded = ['id'];


    public function invoice_items(){

        return $this->hasMany('App\Models\POS\InvoiceItems','id');
    }
    
    public function client(){
    
        return $this->BelongsTo('App\Models\Client','client_id');
    }
 public function  store(){
    
        return $this->belongsTo('App\Models\Location','location');
      }

public function assign(){

    return $this->BelongsTo('App\Models\User','user_agent');
}

public function project(){

    return $this->BelongsTo('App\Models\Project\Project','project_id');
}

public function userAgent()
    {
        return $this->belongsTo(User::class, 'user_agent', 'id');
    }
    
    public function masterHistories()
    {
        return $this->hasMany(MasterHistory::class, 'invoice_id', 'id');
    }
}
