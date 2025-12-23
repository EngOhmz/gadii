<?php

namespace App\Http\Controllers\School;

use App\Models\School\SchoolBranch;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SchoolBranchController extends Controller
{
    public function index()
    {
        $schoolbranches = SchoolBranch::where('added_by', auth()->user()->added_by)->get();
        return view('raja.register.branch', compact('schoolbranches'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:Active,Inactive'
        ]);

        SchoolBranch::create([
            'name' => $request->name,
            'status' => $request->status,
            'added_by' => auth()->user()->added_by
        ]);
        
       
        return redirect()->route('schoolbranch.index')->with('success', 'School Branch added successfully');
    }

    public function edit($id)
    {
     $data = SchoolBranch::find($id);
     
     return view('raja.register.branch',compact('data','id'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:Active,Inactive'
        ]);

        $schoolbranch = SchoolBranch::where('added_by', auth()->user()->added_by)->findOrFail($id);
        $schoolbranch->update([
            'name' => $request->name,
            'status' => $request->status,
            'added_by' => auth()->user()->added_by
        ]);
        
        // Redirect to index without showing the form
        return redirect()->route('schoolbranch.index')->with('success', 'School Branch updated successfully');
    }

    public function destroy($id)
    {
        $schoolbranch = SchoolBranch::where('added_by', auth()->user()->added_by)->findOrFail($id);
        $schoolbranch->delete();
        return redirect()->route('schoolbranch.index')->with('success', 'School Branch deleted successfully');
    }
}