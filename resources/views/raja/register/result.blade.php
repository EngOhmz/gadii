@extends('layouts.master')

@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Manage Student Results</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link @if(empty($result)) active show @endif" data-toggle="tab" href="#list">Student Results List</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if(!empty($result)) active show @endif" data-toggle="tab" href="#form">Add/Edit Student Result</a>
                            </li>
                        </ul>

                        <div class="tab-content pt-3">
                            <!-- List Tab -->
                            <div class="tab-pane fade @if(empty($result)) active show @endif" id="list">
                                <form method="GET" action="{{ route('school_results.index') }}">
                                    <div class="row mb-4">
                                        <div class="col-md-2">
                                            <select name="teacher_id" class="form-control">
                                                <option value="">Select Teacher</option>
                                                @foreach($teachers as $teacher)
                                                    <option value="{{ $teacher->id }}" {{ request('teacher_id') == $teacher->id ? 'selected' : '' }}>
                                                        {{ $teacher->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-2">
                                            <select name="students_class_id" class="form-control">
                                                <option value="">Select Class</option>
                                                @foreach($studentsClasses as $class)
                                                    <option value="{{ $class->id }}" {{ request('students_class_id') == $class->id ? 'selected' : '' }}>
                                                        {{ $class->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-2">
                                            <select name="school_stream_id" class="form-control">
                                                <option value="">Select Stream</option>
                                                @foreach($schoolStreams as $stream)
                                                    <option value="{{ $stream->id }}" {{ request('school_stream_id') == $stream->id ? 'selected' : '' }}>
                                                        {{ $stream->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-2">
                                            <select name="branch_subject_id" class="form-control">
                                                <option value="">Select Subject</option>
                                                @foreach($branchSubjects as $subject)
                                                    <option value="{{ $subject->id }}" {{ request('branch_subject_id') == $subject->id ? 'selected' : '' }}>
                                                        {{ $subject->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-2">
                                            <select name="exam_type_id" class="form-control">
                                                <option value="">Select Exam Type</option>
                                                @foreach($examTypes as $examType)
                                                    <option value="{{ $examType->id }}" {{ request('exam_type_id') == $examType->id ? 'selected' : '' }}>
                                                        {{ $examType->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-2">
                                            <select name="school_term_id" class="form-control">
                                                <option value="">Select Term</option>
                                                @foreach($schoolTerms as $term)
                                                    <option value="{{ $term->id }}" {{ request('school_term_id') == $term->id ? 'selected' : '' }}>
                                                        {{ $term->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-2">
                                            <select name="school_year_id" class="form-control">
                                                <option value="">Select Year</option>
                                                @foreach($schoolYears as $year)
                                                    <option value="{{ $year->id }}" {{ request('school_year_id') == $year->id ? 'selected' : '' }}>
                                                        {{ $year->start_date }} - {{ $year->end_date }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-2 mt-2">
                                            <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                                        </div>
                                    </div>
                                </form>

                                <div class="table-responsive mt-4">
                                    <table class="table table-bordered datatable-basic">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>#</th>
                                                <th>Student</th>
                                                <th>Subject</th>
                                                <th>Exam</th>
                                                <th>Score</th>
                                                <th>Grade</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!empty($results))
                                                @foreach($results as $result)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $result->student->name }}</td>
                                                        <td>{{ $result->branchSubject->name }}</td>
                                                        <td>{{ $result->examType->name }}</td>
                                                        <td>{{ $result->score }}</td>
                                                        <td>{{ $result->grade }}</td>
                                                        <td>
                                                            <div class="form-inline">
                                                                <a class="list-icons-item text-primary" href="{{ route('school_results.edit', $result->id) }}">
                                                                    <i class="icon-pencil7"></i>
                                                                </a>
                                                                &nbsp;
                                                                {!! Form::open(['route' => ['school_results.destroy', $result->id], 'method' => 'delete']) !!}
                                                                {{ Form::button('<i class="icon-trash"></i>', [
                                                                    'type' => 'submit',
                                                                    'style' => 'border:none; background:none;',
                                                                    'class' => 'list-icons-item text-danger',
                                                                    'onclick' => "return confirm('Are you sure?')"
                                                                ]) }}
                                                                {!! Form::close() !!}
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="7" class="text-center">No results found</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Form Tab -->
                            <div class="tab-pane fade @if(!empty($result)) active show @endif" id="form">
                                <div class="card-body">
                                    @if(isset($result))
                                        {!! Form::model($result, ['route' => ['school_results.update', $result->id], 'method' => 'PUT']) !!}
                                    @else
                                        {!! Form::open(['route' => 'school_results.store', 'method' => 'POST']) !!}
                                    @endif

                                    @csrf

                                    <div class="form-group">
                                        <label>Student <span class="text-danger">*</span></label>
                                        <select name="student_id" class="form-control" required>
                                            <option value="">Select Student</option>
                                            @foreach($students as $student)
                                                <option value="{{ $student->id }}" @if(isset($result) && $result->student_id == $student->id) selected @endif>
                                                    {{ $student->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Subject <span class="text-danger">*</span></label>
                                        <select name="branch_subject_id" class="form-control" required>
                                            <option value="">Select Subject</option>
                                            @foreach($branchSubjects as $subject)
                                                <option value="{{ $subject->id }}" @if(isset($result) && $result->branch_subject_id == $subject->id) selected @endif>
                                                    {{ $subject->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Exam Type <span class="text-danger">*</span></label>
                                        <select name="exam_type_id" class="form-control" required>
                                            <option value="">Select Exam Type</option>
                                            @foreach($examTypes as $examType)
                                                <option value="{{ $examType->id }}" @if(isset($result) && $result->exam_type_id == $examType->id) selected @endif>
                                                    {{ $examType->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Class <span class="text-danger">*</span></label>
                                        <select name="students_class_id" class="form-control" required>
                                            <option value="">Select Class</option>
                                            @foreach($studentsClasses as $class)
                                                <option value="{{ $class->id }}" @if(isset($result) && $result->students_class_id == $class->id) selected @endif>
                                                    {{ $class->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Stream <span class="text-danger">*</span></label>
                                        <select name="school_stream_id" class="form-control" required>
                                            <option value="">Select Stream</option>
                                            @foreach($schoolStreams as $stream)
                                                <option value="{{ $stream->id }}" @if(isset($result) && $result->school_stream_id == $stream->id) selected @endif>
                                                    {{ $stream->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Term <span class="text-danger">*</span></label>
                                        <select name="school_term_id" class="form-control" required>
                                            <option value="">Select Term</option>
                                            @foreach($schoolTerms as $term)
                                                <option value="{{ $term->id }}" @if(isset($result) && $result->school_term_id == $term->id) selected @endif>
                                                    {{ $term->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Year <span class="text-danger">*</span></label>
                                        <select name="school_year_id" class="form-control" required>
                                            <option value="">Select Year</option>
                                            @foreach($schoolYears as $year)
                                                <option value="{{ $year->id }}" @if(isset($result) && $result->school_year_id == $year->id) selected @endif>
                                                    {{ $year->start_date }} - {{ $year->end_date }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Score <span class="text-danger">*</span></label>
                                        <input type="number" name="score" class="form-control" value="{{ isset($result) ? $result->score : '' }}" min="0" max="100" required>
                                    </div>

                                    <div class="form-group text-right">
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            @if(isset($result)) Update @else Save @endif
                                        </button>
                                    </div>

                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    $('.datatable-basic').DataTable({
        autoWidth: false,
        columnDefs: [
            { orderable: false, targets: [6] }
        ],
        dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
        language: {
            search: '<span>Filter:</span> _INPUT_',
            searchPlaceholder: 'Type to filter...',
            lengthMenu: '<span>Show:</span> _MENU_',
            paginate: {
                'first': 'First',
                'last': 'Last',
                'next': $('html').attr('dir') == 'rtl' ? '←' : '→',
                'previous': $('html').attr('dir') == 'rtl' ? '→' : '←'
            }
        }
    });
</script>
<script src="{{ url('assets/js/plugins/sweetalert/sweetalert.min.js') }}"></script>
@endsection
