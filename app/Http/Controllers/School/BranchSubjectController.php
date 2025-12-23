<?php

namespace App\Http\Controllers\School;

use App\Models\School\BranchSubject;
use App\Models\School\StudentSubject;
use App\Models\School\SchoolBranch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BranchSubjectController extends Controller
{
    /**
     * Display a listing of the branch-subject relationships.
     */
    public function index()
    {
        $branchSubjects = BranchSubject::with(['subject', 'branch', 'addedBy'])->get();
        return view('branch_subjects.index', compact('branchSubjects'));
    }

    /**
     * Show the form for creating a new branch-subject relationship.
     */
    public function create()
    {
        $subjects = StudentSubject::all(); // Fetch all subjects
        $branches = SchoolBranch::all();   // Fetch all branches
        return view('branch_subjects.create', compact('subjects', 'branches'));
    }

    /**
     * Store a newly created branch-subject relationship in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'subject_id' => 'required|integer',
            'branch_id' => 'required|integer',
        ]);

        BranchSubject::create([
            'subject_id' => $request->subject_id,
            'branch_id' => $request->branch_id,
            'added_by' => Auth::id(), // Set to the authenticated user's ID
        ]);

        return redirect()->route('branchsubject.index')->with('success', 'Branch-Subject relationship created successfully.');
    }

    /**
     * Show the form for editing the specified branch-subject relationship.
     */
    public function edit(BranchSubject $branchsubject)
    {
        $subjects = StudentSubject::all();
        $branches = SchoolBranch::all();
        return view('branch_subjects.edit', compact('branchsubject', 'subjects', 'branches'));
    }

    /**
     * Update the specified branch-subject relationship in storage.
     */
    public function update(Request $request, BranchSubject $branchsubject)
    {
        $request->validate([
            'subject_id' => 'required|integer',
            'branch_id' => 'required|integer',
        ]);

        $branchsubject->update([
            'subject_id' => $request->subject_id,
            'branch_id' => $request->branch_id,
            'added_by' => Auth::id(), // Update with the current authenticated user's ID
        ]);

        return redirect()->route('branchsubject.index')->with('success', 'Branch-Subject relationship updated successfully.');
    }

    /**
     * Remove the specified branch-subject relationship from storage.
     */
    public function destroy(BranchSubject $branchsubject)
    {
        $branchsubject->delete();
        return redirect()->route('branchsubject.index')->with('success', 'Branch-Subject relationship deleted successfully.');
    }
}