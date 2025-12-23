<?php

namespace App\Http\Controllers\School;

use App\Models\School\SchoolStreams;
use App\Models\School\StudentsClass;
use App\Models\School\StudentLevel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SchoolStreamsController extends Controller
{
    public function index()
    {
        $schoolstreams = SchoolStreams::where('added_by', auth()->user()->added_by)
            ->with(['class', 'level'])
            ->get();
        $classes = StudentsClass::where('added_by', auth()->user()->added_by)->where('status', 'Active')->get();
        $levels = StudentLevel::where('added_by', auth()->user()->added_by)->where('status', 'Active')->get();
        return view('raja.register.streams', compact('schoolstreams', 'classes', 'levels'));
    }

    public function create()
    {
        $classes = StudentsClass::where('added_by', auth()->user()->added_by)->where('status', 'Active')->get();
        $levels = StudentLevel::where('added_by', auth()->user()->added_by)->where('status', 'Active')->get();
        return view('raja.register.streams', compact('classes', 'levels'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'class_id' => 'required|string|max:255',
            'level_id' => 'required|string|max:255',
            'status' => 'required|in:Active,Inactive'
        ]);

        SchoolStreams::create([
            'name' => $request->name,
            'class_id' => $request->class_id,
            'level_id' => $request->level_id,
            'status' => $request->status,
            'added_by' => auth()->user()->added_by
        ]);

        return redirect()->route('schoolstreams.index')->with('success', 'School Stream added successfully');
    }

    public function edit($id)
    {
        $data = SchoolStreams::where('added_by', auth()->user()->added_by)->findOrFail($id);
        $classes = StudentsClass::where('added_by', auth()->user()->added_by)->where('status', 'Active')->get();
        $levels = StudentLevel::where('added_by', auth()->user()->added_by)->where('status', 'Active')->get();
        return view('raja.register.streams', compact('data', 'id', 'classes', 'levels'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'class_id' => 'required|string|max:255',
            'level_id' => 'required|string|max:255',
            'status' => 'required|in:Active,Inactive'
        ]);

        $schoolstream = SchoolStreams::where('added_by', auth()->user()->added_by)->findOrFail($id);
        $schoolstream->update([
            'name' => $request->name,
            'class_id' => $request->class_id,
            'level_id' => $request->level_id,
            'status' => $request->status,
            'added_by' => auth()->user()->added_by
        ]);

        return redirect()->route('schoolstreams.index')->with('success', 'School Stream updated successfully');
    }

    public function destroy($id)
    {
        $schoolstream = SchoolStreams::where('added_by', auth()->user()->added_by)->findOrFail($id);
        $schoolstream->delete();
        return redirect()->route('schoolstreams.index')->with('success', 'School Stream deleted successfully');
    }
}