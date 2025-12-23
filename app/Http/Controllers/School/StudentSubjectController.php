<?php

namespace App\Http\Controllers\School;

use App\Models\School\StudentSubject;
use App\Models\School\StudentLevel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StudentSubjectController extends Controller
{
    public function index()
    {
        $studentsubjects = StudentSubject::where('added_by', auth()->user()->added_by)->with('level')->get();
        $levels = StudentLevel::where('added_by', auth()->user()->added_by)->where('status', 'Active')->get();
        return view('raja.register.subject', compact('studentsubjects', 'levels'));
    }

    public function create()
    {
        $levels = StudentLevel::where('added_by', auth()->user()->added_by)->where('status', 'Active')->get();
        return view('raja.register.subject', compact('levels'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'level_id' => 'required|string|max:255',
            'status' => 'required|in:Active,Inactive'
        ]);

        StudentSubject::create([
            'name' => $request->name,
            'level_id' => $request->level_id,
            'status' => $request->status,
            'added_by' => auth()->user()->added_by
        ]);
        
        return redirect()->route('studentsubject.index')->with('success', 'Student Subject added successfully');
    }

    public function edit($id)
    {
        $data = StudentSubject::where('added_by', auth()->user()->added_by)->findOrFail($id);
        $levels = StudentLevel::where('added_by', auth()->user()->added_by)->where('status', 'Active')->get();
        return view('raja.register.subject', compact('data', 'id', 'levels'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'level_id' => 'required|string|max:255',
            'status' => 'required|in:Active,Inactive'
        ]);

        $studentsubject = StudentSubject::where('added_by', auth()->user()->added_by)->findOrFail($id);
        $studentsubject->update([
            'name' => $request->name,
            'level_id' => $request->level_id,
            'status' => $request->status,
            'added_by' => auth()->user()->added_by
        ]);
        
        return redirect()->route('studentsubject.index')->with('success', 'Student Subject updated successfully');
    }

    public function destroy($id)
    {
        $studentsubject = StudentSubject::where('added_by', auth()->user()->added_by)->findOrFail($id);
        $studentsubject->delete();
        return redirect()->route('studentsubject.index')->with('success', 'Student Subject deleted successfully');
    }
}