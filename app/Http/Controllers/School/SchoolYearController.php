<?php

namespace App\Http\Controllers\School;

use App\Models\School\SchoolYear;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SchoolYearController extends Controller
{
    public function index()
    {
        $schoolyears = SchoolYear::where('added_by', auth()->user()->added_by)->get();
        return view('raja.register.year', compact('schoolyears'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date'
        ]);

        SchoolYear::create([
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'added_by' => auth()->user()->added_by
        ]);
        
        return redirect()->route('schoolyears.index')->with('success', 'School Year added successfully');
    }

    public function edit($id)
    {
        $data = SchoolYear::find($id);
        return view('raja.register.year', compact('data', 'id'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date'
        ]);

        $schoolyear = SchoolYear::findOrFail($id);
        $schoolyear->update([
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'added_by' => auth()->user()->added_by
        ]);
        
        return redirect()->route('schoolyears.index')->with('success', 'School Year updated successfully');
    }

    public function destroy($id)
    {
        $schoolyear = SchoolYear::findOrFail($id);
        $schoolyear->delete();
        return redirect()->route('schoolyears.index')->with('success', 'School Year deleted successfully');
    }
}