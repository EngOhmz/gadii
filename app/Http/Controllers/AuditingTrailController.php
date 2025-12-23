<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\SystemModule;

class AuditingTrailController extends Controller
{  
   
    public function index()
    {  
        $permissions = Branch::all()->where('disabled','0')->where('added_by', auth()->user()->added_by);
        return view('manage.branch.index', compact('permissions'));
    }

   
}