<?php

namespace App\Http\Controllers\School;

use App\Models\School\StudentResult;
use App\Models\School\StudentsClass;
use App\Models\School\SchoolStreams;
use App\Models\School\BranchSubject;
use App\Models\School\ExamType;
use App\Models\School\SchoolTerm;
use App\Models\School\SchoolYear;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StudentsResultController extends Controller
{
    public function index(Request $request)
    {
        $teachers = User::where('added_by', auth()->user()->added_by)->get();
        $studentsClasses = StudentsClass::where('added_by', auth()->user()->added_by)->get();
        $schoolStreams = SchoolStreams::where('added_by', auth()->user()->added_by)->get();
        $branchSubjects = BranchSubject::where('added_by', auth()->user()->added_by)->get();
        $examTypes = ExamType::where('added_by', auth()->user()->added_by)->get();
        $schoolTerms = SchoolTerm::where('added_by', auth()->user()->added_by)->get();
        $schoolYears = SchoolYear::where('added_by', auth()->user()->added_by)->get();
        $students = User::where('added_by', auth()->user()->added_by)->get(); // Added for student dropdown

        $results = StudentResult::query()
            ->where('added_by', auth()->user()->added_by)
            ->with(['student', 'branchSubject', 'examType', 'studentsClass', 'schoolStream', 'schoolTerm', 'schoolYear'])
            ->when($request->students_class_id, function ($query, $classId) {
                return $query->where('students_class_id', $classId);
            })
            ->when($request->school_stream_id, function ($query, $streamId) {
                return $query->where('school_stream_id', $streamId);
            })
            ->when($request->teacher_id, function ($query, $teacherId) {
                return $query->whereHas('student', function ($q) use ($teacherId) {
                    $q->where('added_by', $teacherId);
                });
            })
            ->when($request->branch_subject_id, function ($query, $subjectId) {
                return $query->where('branch_subject_id', $subjectId);
            })
            ->when($request->exam_type_id, function ($query, $examId) {
                return $query->where('exam_type_id', $examId);
            })
            ->when($request->school_term_id, function ($query, $termId) {
                return $query->where('school_term_id', $termId);
            })
            ->when($request->school_year_id, function ($query, $yearId) {
                return $query->where('school_year_id', $yearId);
            })
            ->get();

        return view('raja.register.result', compact(
            'teachers', 'studentsClasses', 'schoolStreams', 'branchSubjects',
            'examTypes', 'schoolTerms', 'schoolYears', 'results', 'students'
        ));
    }

    public function create()
    {
        $teachers = User::where('added_by', auth()->user()->added_by)->get();
        $studentsClasses = StudentsClass::where('added_by', auth()->user()->added_by)->get();
        $schoolStreams = SchoolStreams::where('added_by', auth()->user()->added_by)->get();
        $branchSubjects = BranchSubject::where('added_by', auth()->user()->added_by)->get();
        $examTypes = ExamType::where('added_by', auth()->user()->added_by)->get();
        $schoolTerms = SchoolTerm::where('added_by', auth()->user()->added_by)->get();
        $schoolYears = SchoolYear::where('added_by', auth()->user()->added_by)->get();
        $students = User::where('added_by', auth()->user()->added_by)->get();

        return view('raja.register.result_create', compact(
            'teachers', 'studentsClasses', 'schoolStreams', 'branchSubjects',
            'examTypes', 'schoolTerms', 'schoolYears', 'students'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|integer',
            'branch_subject_id' => 'required|integer',
            'exam_type_id' => 'required|integer',
            'students_class_id' => 'required|integer',
            'school_stream_id' => 'required|integer',
            'school_term_id' => 'required|integer',
            'school_year_id' => 'required|integer',
            'score' => 'required|integer|min:0|max:100',
        ]);

        StudentResult::create([
            'student_id' => $request->student_id,
            'branch_subject_id' => $request->branch_subject_id,
            'exam_type_id' => $request->exam_type_id,
            'students_class_id' => $request->students_class_id,
            'school_stream_id' => $request->school_stream_id,
            'school_term_id' => $request->school_term_id,
            'school_year_id' => $request->school_year_id,
            'score' => $request->score,
            'added_by' => auth()->user()->added_by
        ]);

        return redirect()->route('school_results.index')->with('success', 'Student Result added successfully');
    }

    public function show($id)
    {
        $result = StudentResult::where('added_by', auth()->user()->added_by)
            ->with(['student', 'branchSubject', 'examType', 'studentsClass', 'schoolStream', 'schoolTerm', 'schoolYear'])
            ->findOrFail($id);

        return view('raja.register.result_show', compact('result'));
    }

    public function edit($id)
    {
        $result = StudentResult::where('added_by', auth()->user()->added_by)->findOrFail($id);
        $teachers = User::where('added_by', auth()->user()->added_by)->get();
        $studentsClasses = StudentsClass::where('added_by', auth()->user()->added_by)->get();
        $schoolStreams = SchoolStreams::where('added_by', auth()->user()->added_by)->get();
        $branchSubjects = BranchSubject::where('added_by', auth()->user()->added_by)->get();
        $examTypes = ExamType::where('added_by', auth()->user()->added_by)->get();
        $schoolTerms = SchoolTerm::where('added_by', auth()->user()->added_by)->get();
        $schoolYears = SchoolYear::where('added_by', auth()->user()->added_by)->get();
        $students = User::where('added_by', auth()->user()->added_by)->get();

        return view('raja.register.result_edit', compact(
            'result', 'teachers', 'studentsClasses', 'schoolStreams', 'branchSubjects',
            'examTypes', 'schoolTerms', 'schoolYears', 'students'
        ));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'student_id' => 'required|integer',
            'branch_subject_id' => 'required|integer',
            'exam_type_id' => 'required|integer',
            'students_class_id' => 'required|integer',
            'school_stream_id' => 'required|integer',
            'school_term_id' => 'required|integer',
            'school_year_id' => 'required|integer',
            'score' => 'required|integer|min:0|max:100',
        ]);

        $result = StudentResult::where('added_by', auth()->user()->added_by)->findOrFail($id);
        $result->update([
            'student_id' => $request->student_id,
            'branch_subject_id' => $request->branch_subject_id,
            'exam_type_id' => $request->exam_type_id,
            'students_class_id' => $request->students_class_id,
            'school_stream_id' => $request->school_stream_id,
            'school_term_id' => $request->school_term_id,
            'school_year_id' => $request->school_year_id,
            'score' => $request->score,
            'added_by' => auth()->user()->added_by
        ]);

        return redirect()->route('school_results.index')->with('success', 'Student Result updated successfully');
    }

    public function destroy($id)
    {
        $result = StudentResult::where('added_by', auth()->user()->added_by)->findOrFail($id);
        $result->delete();

        return redirect()->route('school_results.index')->with('success', 'Student Result deleted successfully');
    }

    public function school_report()
    {
        return view('raja.register.report');
    }
}