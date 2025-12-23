@extends('layouts.master')

@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Add Student Result</h4>
                    </div>
                    <div class="card-body">
                        {!! Form::open(['route' => 'school_results.store', 'method' => 'POST']) !!}
                        @csrf

                        <div class="form-group">
                            <label>Student <span class="text-danger">*</span></label>
                            <select name="student_id" class="form-control" required>
                                <option value="">Select Student</option>
                                @foreach($students as $student)
                                    <option value="{{ $student->id }}">{{ $student->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Subject <span class="text-danger">*</span></label>
                            <select name="branch_subject_id" class="form-control" required>
                                <option value="">Select Subject</option>
                                @foreach($branchSubjects as $subject)
                                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Exam Type <span class="text-danger">*</span></label>
                            <select name="exam_type_id" class="form-control" required>
                                <option value="">Select Exam Type</option>
                                @foreach($examTypes as $examType)
                                    <option value="{{ $examType->id }}">{{ $examType->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Class <span class="text-danger">*</span></label>
                            <select name="students_class_id" class="form-control" required>
                                <option value="">Select Class</option>
                                @foreach($studentsClasses as $class)
                                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Stream <span class="text-danger">*</span></label>
                            <select name="school_stream_id" class="form-control" required>
                                <option value="">Select Stream</option>
                                @foreach($schoolStreams as $stream)
                                    <option value="{{ $stream->id }}">{{ $stream->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Term <span class="text-danger">*</span></label>
                            <select name="school_term_id" class="form-control" required>
                                <option value="">Select Term</option>
                                @foreach($schoolTerms as $term)
                                    <option value="{{ $term->id }}">{{ $term->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Year <span class="text-danger">*</span></label>
                            <select name="school_year_id" class="form-control" required>
                                <option value="">Select Year</option>
                                @foreach($schoolYears as $year)
                                    <option value="{{ $year->id }}">{{ $year->start_date }} - {{ $year->end_date }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Score <span class="text-danger">*</span></label>
                            <input type="number" name="score" class="form-control" min="0" max="100" required>
                        </div>

                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-primary btn-sm">Save</button>
                        </div>

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection