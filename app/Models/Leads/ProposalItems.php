<?php

namespace App\Models\Leads;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProposalItems extends Model
{
    use HasFactory;
    protected $table = "tbl_leads_proposal_items";
    protected  $guarded = ['id'];

}
