<?php

namespace App\Models\Leads;

use Illuminate\Database\Eloquent\Model;

class Leads extends Model
{
    protected $table = "tbl_leads";

    protected $guarded = ['id'];
    
      public function client()
    {
        return $this->belongsTo('App\Models\Client', 'client_id');
    }
      public function status()
    {
        return $this->belongsTo('App\Models\Leads\LeadStatus', 'status_id');
    }
    
       public function source()
    {
        return $this->belongsTo('App\Models\Leads\LeadSource', 'source_id');
    }
    
 public function assign(){
    
        return $this->belongsTo('App\Models\User','assigned_to');
      }

 public function user(){
    
        return $this->belongsTo('App\Models\User','added_by');
      }

  public function country()
    {
        return $this->belongsTo('App\Models\Country', 'country_id');
    }

public function language()
    {
        return $this->belongsTo('App\Models\Language', 'language_id');
    }

}
