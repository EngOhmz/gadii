<?php

namespace App\Models\Leads;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
    use HasFactory;
    protected $table = "tbl_leads_proposal";
    protected  $guarded = ['id'];


    public function invoice_items(){

        return $this->hasMany('App\Models\Leads\ProposalItems','id');
    }
    
    public function client(){
    
        return $this->BelongsTo('App\Models\Client','client_id');
    }
 public function  store(){
    
        return $this->belongsTo('App\Models\Location','location');
      }
}
