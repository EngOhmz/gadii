<?php

namespace App\Http\Controllers\School;

use App\Models\School\SchoolTerm;
use App\Models\School\SchoolYear;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SchoolTermController extends Controller
{
    public function index()
    {
        $schoolterms = SchoolTerm::where('added_by', auth()->user()->added_by)->with('schoolYear')->get();
        $schoolyears = SchoolYear::where('added_by', auth()->user()->added_by)->get();
        return view('raja.register.terms', compact('schoolterms', 'schoolyears'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'school_year_id' => 'required|integer',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date'
        ]);

        SchoolTerm::create([
            'name' => $request->name,
            'school_year_id' => $request->school_year_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'added_by' => auth()->user()->added_by
        ]);
        
        return redirect()->route('schoolterms.index')->with('success', 'School Term added successfully');
    }

    public function edit($id)
    {
        $data = SchoolTerm::find($id);
        $schoolyears = SchoolYear::where('added_by', auth()->user()->added_by)->get();
        return view('raja.register.terms', compact('data', 'id', 'schoolyears'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'school_year_id' => 'required|integer',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date'
        ]);

        $schoolterm = SchoolTerm::findOrFail($id);
        $schoolterm->update([
            'name' => $request->name,
            'school_year_id' => $request->school_year_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'added_by' => auth()->user()->added_by
        ]);
        
        return redirect()->route('schoolterms.index')->with('success', 'School Term updated successfully');
    }

    public function destroy($id)
    {
        $schoolterm = SchoolTerm::findOrFail($id);
        $schoolterm->delete();
        return redirect()->route('schoolterms.index')->with('success', 'School Term deleted successfully');
    }
}