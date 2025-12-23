<?php

namespace App\Models\Leads;

use Illuminate\Database\Eloquent\Model;

class ProposalAssignment extends Model
{
    protected $table = "tbl_proposal_assignment";

    protected $guarded = ['id'];
    
      public function proposal()
    {
        return $this->belongsTo('App\Models\Leads\Proposal', 'proposal_id');
    }
  

  public function assign()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

}