<?php

namespace App\Http\Controllers\School;

use App\Models\User;
use App\Models\School\StudentSubject;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TeachersRegisterController extends Controller
{
    public function index()
    {
        $teachers = User::where('added_by', auth()->user()->added_by)->get();
        $subjects = StudentSubject::where('added_by', auth()->user()->added_by)->get();
        return view('raja.register.teachers', compact('teachers', 'subjects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'teacher_id' => 'required|exists:users,id',
            'subject_ids' => 'required|array',
            'subject_ids.*' => 'exists:student_subjects,id'
        ]);

        $teacher = User::where('added_by', auth()->user()->added_by)
                      ->findOrFail($request->teacher_id);
        $teacher->subjects()->sync($request->subject_ids);

        return redirect()->route('teachersregister.index')
                        ->with('success', 'Teacher subjects assigned successfully');
    }

    public function edit($id)
    {
        $teacher = User::where('added_by', auth()->user()->added_by)->findOrFail($id);
        $teachers = User::where('added_by', auth()->user()->added_by)->get();
        $subjects = StudentSubject::where('added_by', auth()->user()->added_by)->get();

        return view('raja.register.teachers', compact('teacher', 'teachers', 'subjects'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'subject_ids' => 'required|array',
            'subject_ids.*' => 'exists:student_subjects,id'
        ]);

        $teacher = User::where('added_by', auth()->user()->added_by)->findOrFail($id);
        $teacher->subjects()->sync($request->subject_ids);

        return redirect()->route('teachersregister.index')
                        ->with('success', 'Teacher subjects updated successfully');
    }

    public function destroy($id)
    {
        $teacher = User::where('added_by', auth()->user()->added_by)->findOrFail($id);
        $teacher->subjects()->detach();

        return redirect()->route('teachersregister.index')
                        ->with('success', 'Teacher subject assignments removed successfully');
    }
}