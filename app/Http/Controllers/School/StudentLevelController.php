<?php

namespace App\Http\Controllers\School;

use App\Models\School\StudentLevel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StudentLevelController extends Controller
{
    public function index()
    {
        $studentlevels = StudentLevel::where('added_by', auth()->user()->added_by)->get();
        return view('raja.register.index', compact('studentlevels'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:Active,Inactive'
        ]);

        StudentLevel::create([
            'name' => $request->name,
            'status' => $request->status,
            'added_by' => auth()->user()->added_by
        ]);
        
        return redirect()->route('studentlevels.index')->with('success', 'Student Level added successfully');
    }

    public function edit($id)
    {
         $data = StudentLevel::find($id);
         
         return view('raja.register.index',compact('data','id'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:Active,Inactive'
        ]);

        $studentlevel = StudentLevel::findOrFail($id);
        $studentlevel->update([
            'name' => $request->name,
            'status' => $request->status,
            'added_by' => auth()->user()->added_by
        ]);
        
        return redirect()->route('studentlevels.index')->with('success', 'Student Level updated successfully');
    }

    public function destroy($id)
    {
        $studentlevel = StudentLevel::findOrFail($id);
        $studentlevel->delete();
        return redirect()->route('studentlevels.index')->with('success', 'Student Level deleted successfully');
    }
}