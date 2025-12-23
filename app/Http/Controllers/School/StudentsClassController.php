<?php

namespace App\Http\Controllers\School;

use App\Models\School\StudentsClass;
use App\Models\School\StudentLevel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StudentsClassController extends Controller
{
    public function index()
    {
        $studentsclasses = StudentsClass::where('added_by', auth()->user()->added_by)->with('level')->get();
        $levels = StudentLevel::where('added_by', auth()->user()->added_by)->where('status', 'Active')->get();
        return view('raja.register.class', compact('studentsclasses', 'levels'));
    }

    public function create()
    {
        $levels = StudentLevel::where('added_by', auth()->user()->added_by)->where('status', 'Active')->get();
        return view('raja.register.class', compact('levels'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:Active,Inactive',
            'level_id' => 'required|exists:student_levels,id'
        ]);

        StudentsClass::create([
            'name' => $request->name,
            'status' => $request->status,
            'level_id' => $request->level_id,
            'added_by' => auth()->user()->added_by
        ]);
        
        return redirect()->route('studentsclass.index')->with('success', 'Student Class added successfully');
    }

    public function edit($id)
    {
        $data = StudentsClass::where('added_by', auth()->user()->added_by)->findOrFail($id);
        $levels = StudentLevel::where('added_by', auth()->user()->added_by)->where('status', 'Active')->get();
        return view('raja.register.class', compact('data', 'id', 'levels'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:Active,Inactive',
            'level_id' => 'required|exists:student_levels,id'
        ]);

        $studentsclass = StudentsClass::where('added_by', auth()->user()->added_by)->findOrFail($id);
        $studentsclass->update([
            'name' => $request->name,
            'status' => $request->status,
            'level_id' => $request->level_id,
            'added_by' => auth()->user()->added_by
        ]);
        
        return redirect()->route('studentsclass.index')->with('success', 'Student Class updated successfully');
    }

    public function destroy($id)
    {
        $studentsclass = StudentsClass::where('added_by', auth()->user()->added_by)->findOrFail($id);
        $studentsclass->delete();
        return redirect()->route('studentsclass.index')->with('success', 'Student Class deleted successfully');
    }
}