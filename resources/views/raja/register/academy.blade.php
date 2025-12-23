@extends('layouts.master')

@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Manage Academy Registers</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link @if(empty($id)) active show @endif" data-toggle="tab" href="#list">Academy Registers List</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if(!empty($id)) active show @endif" data-toggle="tab" href="#tab2">Add/Edit Academy Register</a>
                            </li>
                        </ul>

                        <div class="tab-content pt-3">
                            <!-- List Tab -->
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="list">
                                <div class="table-responsive">
                                    <table class="table datatable-basic table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Teacher</th>
                                                <th>Subject</th>
                                                <th>Class</th>
                                                <th>Stream</th>
                                                <th>Exam Type</th>
                                                <th>School Year</th>
                                                <th>Term</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!empty($academyregisters))
                                            @foreach($academyregisters as $academyregister)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $academyregister->user->name }}</td>
                                                <td>{{ $academyregister->branchSubject->name }}</td>
                                                <td>{{ $academyregister->studentsClass->name }}</td>
                                                <td>{{ $academyregister->schoolStream->name }}</td>
                                                <td>{{ $academyregister->examType->name }}</td>
                                                <td>{{ $academyregister->schoolYear->start_date }} - {{ $academyregister->schoolYear->end_date }}</td>
                                                <td>{{ $academyregister->schoolTerm->name }}</td>
                                                <td>
                                                    <div class="form-inline">
                                                        <a class="list-icons-item text-primary" href="{{ route('academyregisters.edit', $academyregister->id) }}">
                                                            <i class="icon-pencil7"></i>
                                                        </a>
                                                        &nbsp;
                                                        {!! Form::open(['route' => ['academyregisters.destroy', $academyregister->id], 'method' => 'delete']) !!}
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
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Form Tab -->
                            <div class="tab-pane fade @if(!empty($id)) active show @endif" id="tab2">
                                <div class="card-body">
                                    @if(isset($id))
                                        {!! Form::model($data, ['route' => ['academyregisters.update', $id], 'method' => 'PUT']) !!}
                                    @else
                                        {!! Form::open(['route' => 'academyregisters.store', 'method' => 'POST']) !!}
                                    @endif

                                    @csrf

                                    <div class="form-group">
                                        <label>Teacher <span class="text-danger">*</span></label>
                                        <select name="user_id" class="form-control" required>
                                            <option value="">Select Teacher</option>
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}" @if(isset($data) && $data->user_id == $user->id) selected @endif>
                                                    {{ $user->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Subject <span class="text-danger">*</span></label>
                                        <select name="branch_subject_id" class="form-control" required>
                                            <option value="">Select Subject</option>
                                            @foreach($branchsubjects as $subject)
                                                <option value="{{ $subject->id }}" @if(isset($data) && $data->branch_subject_id == $subject->id) selected @endif>
                                                    {{ $subject->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Class <span class="text-danger">*</span></label>
                                        <select name="students_class_id" class="form-control" required>
                                            <option value="">Select Class</option>
                                            @foreach($studentsclasses as $class)
                                                <option value="{{ $class->id }}" @if(isset($data) && $data->students_class_id == $class->id) selected @endif>
                                                    {{ $class->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Stream <span class="text-danger">*</span></label>
                                        <select name="school_stream_id" class="form-control" required>
                                            <option value="">Select Stream</option>
                                            @foreach($schoolstreams as $stream)
                                                <option value="{{ $stream->id }}" @if(isset($data) && $data->school_stream_id == $stream->id) selected @endif>
                                                    {{ $stream->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Exam Type <span class="text-danger">*</span></label>
                                        <select name="exam_type_id" class="form-control" required>
                                            <option value="">Select Exam Type</option>
                                            @foreach($examtypes as $examtype)
                                                <option value="{{ $examtype->id }}" @if(isset($data) && $data->exam_type_id == $examtype->id) selected @endif>
                                                    {{ $examtype->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>School Year <span class="text-danger">*</span></label>
                                        <select name="school_year_id" class="form-control" required>
                                            <option value="">Select School Year</option>
                                            @foreach($schoolyears as $schoolyear)
                                                <option value="{{ $schoolyear->id }}" @if(isset($data) && $data->school_year_id == $schoolyear->id) selected @endif>
                                                    {{ $schoolyear->start_date }} - {{ $schoolyear->end_date }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Term <span class="text-danger">*</span></label>
                                        <select name="school_term_id" class="form-control" required>
                                            <option value="">Select Term</option>
                                            @foreach($schoolterms as $schoolterm)
                                                <option value="{{ $schoolterm->id }}" @if(isset($data) && $data->school_term_id == $schoolterm->id) selected @endif>
                                                    {{ $schoolterm->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group text-right">
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            @if(!empty($id)) Update @else Save @endif
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
            { orderable: false, targets: [8] }
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
        },
    });
</script>
<script src="{{ url('assets/js/plugins/sweetalert/sweetalert.min.js') }}"></script>
@endsection