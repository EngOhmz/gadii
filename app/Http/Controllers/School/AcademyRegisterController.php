<?php

namespace App\Http\Controllers\School;

use App\Models\School\AcademyRegister;
use App\Models\User;
use App\Models\School\StudentSubject;
use App\Models\School\StudentsClass;
use App\Models\School\SchoolStreams;
use App\Models\School\ExamType;
use App\Models\School\SchoolYear;
use App\Models\School\SchoolTerm;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AcademyRegisterController extends Controller
{
    public function index()
    {
        $academyregisters = AcademyRegister::where('added_by', auth()->user()->added_by)
            ->with(['user', 'branchSubject', 'studentsClass', 'schoolStream', 'examType', 'schoolYear', 'schoolTerm'])
            ->get();
        $users = User::where('added_by', auth()->user()->added_by)->get();
        $branchsubjects = StudentSubject::where('added_by', auth()->user()->added_by)->get();
        $studentsclasses = StudentsClass::where('added_by', auth()->user()->added_by)->get();
        $schoolstreams = SchoolStreams::where('added_by', auth()->user()->added_by)->get();
        $examtypes = ExamType::where('added_by', auth()->user()->added_by)->get();
        $schoolyears = SchoolYear::where('added_by', auth()->user()->added_by)->get();
        $schoolterms = SchoolTerm::where('added_by', auth()->user()->added_by)->get();

        return view('raja.register.academy', compact(
            'academyregisters', 'users', 'branchsubjects', 'studentsclasses',
            'schoolstreams', 'examtypes', 'schoolyears', 'schoolterms'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'branch_subject_id' => 'required|integer',
            'students_class_id' => 'required|integer',
            'school_stream_id' => 'required|integer',
            'exam_type_id' => 'required|integer',
            'school_year_id' => 'required|integer',
            'school_term_id' => 'required|integer'
        ]);

        AcademyRegister::create([
            'user_id' => $request->user_id,
            'branch_subject_id' => $request->branch_subject_id,
            'students_class_id' => $request->students_class_id,
            'school_stream_id' => $request->school_stream_id,
            'exam_type_id' => $request->exam_type_id,
            'school_year_id' => $request->school_year_id,
            'school_term_id' => $request->school_term_id,
            'added_by' => auth()->user()->added_by
        ]);

        return redirect()->route('academyregisters.index')->with('success', 'Academy Register added successfully');
    }

    public function edit($id)
    {
        $data = AcademyRegister::find($id);
        $users = User::where('added_by', auth()->user()->added_by)->get();
        $branchsubjects = StudentSubject::where('added_by', auth()->user()->added_by)->get();
        $studentsclasses = StudentsClass::where('added_by', auth()->user()->added_by)->get();
        $schoolstreams = SchoolStreams::where('added_by', auth()->user()->added_by)->get();
        $examtypes = ExamType::where('added_by', auth()->user()->added_by)->get();
        $schoolyears = SchoolYear::where('added_by', auth()->user()->added_by)->get();
        $schoolterms = SchoolTerm::where('added_by', auth()->user()->added_by)->get();

        return view('raja.register.academy', compact(
            'data', 'id', 'users', 'branchsubjects', 'studentsclasses',
            'schoolstreams', 'examtypes', 'schoolyears', 'schoolterms'
        ));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'branch_subject_id' => 'required|integer',
            'students_class_id' => 'required|integer',
            'school_stream_id' => 'required|integer',
            'exam_type_id' => 'required|integer',
            'school_year_id' => 'required|integer',
            'school_term_id' => 'required|integer'
        ]);

        $academyregister = AcademyRegister::findOrFail($id);
        $academyregister->update([
            'user_id' => $request->user_id,
            'branch_subject_id' => $request->branch_subject_id,
            'students_class_id' => $request->students_class_id,
            'school_stream_id' => $request->school_stream_id,
            'exam_type_id' => $request->exam_type_id,
            'school_year_id' => $request->school_year_id,
            'school_term_id' => $request->school_term_id,
            'added_by' => auth()->user()->added_by
        ]);

        return redirect()->route('academyregisters.index')->with('success', 'Academy Register updated successfully');
    }

    public function destroy($id)
    {
        $academyregister = AcademyRegister::findOrFail($id);
        $academyregister->delete();
        return redirect()->route('academyregisters.index')->with('success', 'Academy Register deleted successfully');
    }
}