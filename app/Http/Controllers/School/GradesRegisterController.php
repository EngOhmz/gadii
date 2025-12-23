<?php

namespace App\Http\Controllers\School;

use App\Models\School\GradesRegister;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GradesRegisterController extends Controller
{
    public function index()
    {
        $gradesregisters = GradesRegister::where('added_by', auth()->user()->added_by)->get();
        return view('raja.register.grades', compact('gradesregisters'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:10', // e.g., A, B, C
            'range' => 'required|string|max:20' // e.g., 70-100
        ]);

        GradesRegister::create([
            'name' => $request->name,
            'range' => $request->range,
            'added_by' => auth()->user()->added_by
        ]);
        
        // Redirect to index without showing the form
        return redirect()->route('gradesregister.index')->with('success', 'Grade added successfully');
    }

    public function edit($id)
    {
     $data = GradesRegister::find($id);
     
     return view('raja.register.grades',compact('data','id'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:10',
            'range' => 'required|string|max:20'
        ]);

        $gradesregister = GradesRegister::where('added_by', auth()->user()->added_by)->findOrFail($id);
        $gradesregister->update([
            'name' => $request->name,
            'range' => $request->range,
            'added_by' => auth()->user()->added_by
        ]);
        
        // Redirect to index without showing the form
        return redirect()->route('gradesregister.index')->with('success', 'Grade updated successfully');
    }

    public function destroy($id)
    {
        $gradesregister = GradesRegister::where('added_by', auth()->user()->added_by)->findOrFail($id);
        $gradesregister->delete();
        return redirect()->route('gradesregister.index')->with('success', 'Grade deleted successfully');
    }
}