<?php

namespace App\Http\Controllers\School;

use App\Models\School\ExamType;
use App\Models\School\StudentLevel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ExamTypeController extends Controller
{
    public function index()
    {
        $examtypes = ExamType::where('added_by', auth()->user()->added_by)->with('level')->get();
        $levels = StudentLevel::where('added_by', auth()->user()->added_by)->where('status', 'Active')->get();
        return view('raja.register.examtype', compact('examtypes', 'levels'));
    }

    public function create()
    {
        $levels = StudentLevel::where('added_by', auth()->user()->added_by)->where('status', 'Active')->get();
        return view('raja.register.examtype', compact('levels'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'level_id' => 'required|string|max:255',
            'status' => 'required|in:Active,Inactive'
        ]);

        ExamType::create([
            'name' => $request->name,
            'level_id' => $request->level_id,
            'status' => $request->status,
            'added_by' => auth()->user()->added_by
        ]);
        
        return redirect()->route('examtype.index')->with('success', 'Exam Type added successfully');
    }

    public function edit($id)
    {
        $data = ExamType::where('added_by', auth()->user()->added_by)->findOrFail($id);
        $levels = StudentLevel::where('added_by', auth()->user()->added_by)->where('status', 'Active')->get();
        return view('raja.register.examtype', compact('data', 'id', 'levels'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'level_id' => 'required|string|max:255',
            'status' => 'required|in:Active,Inactive'
        ]);

        $examtype = ExamType::where('added_by', auth()->user()->added_by)->findOrFail($id);
        $examtype->update([
            'name' => $request->name,
            'level_id' => $request->level_id,
            'status' => $request->status,
            'added_by' => auth()->user()->added_by
        ]);
        
        return redirect()->route('examtype.index')->with('success', 'Exam Type updated successfully');
    }

    public function destroy($id)
    {
        $examtype = ExamType::where('added_by', auth()->user()->added_by)->findOrFail($id);
        $examtype->delete();
        return redirect()->route('examtype.index')->with('success', 'Exam Type deleted successfully');
    }
}