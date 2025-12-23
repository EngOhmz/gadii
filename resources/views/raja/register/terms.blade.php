@extends('layouts.master')

@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Manage School Terms</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link @if(empty($id)) active show @endif" data-toggle="tab" href="#list">School Terms List</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if(!empty($id)) active show @endif" data-toggle="tab" href="#tab2">Add/Edit School Term</a>
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
                                                <th>Name</th>
                                                <th>School Year</th>
                                                <th>Start Date</th>
                                                <th>End Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!empty($schoolterms))
                                            @foreach($schoolterms as $schoolterm)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $schoolterm->name }}</td>
                                                <td>{{ $schoolterm->schoolYear->start_date }} - {{ $schoolterm->schoolYear->end_date }}</td>
                                                <td>{{ $schoolterm->start_date }}</td>
                                                <td>{{ $schoolterm->end_date }}</td>
                                                <td>
                                                    <div class="form-inline">
                                                        <a class="list-icons-item text-primary" href="{{ route('schoolterms.edit', $schoolterm->id) }}">
                                                            <i class="icon-pencil7"></i>
                                                        </a>
                                                        &nbsp;
                                                        {!! Form::open(['route' => ['schoolterms.destroy', $schoolterm->id], 'method' => 'delete']) !!}
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
                                        {!! Form::model($data, ['route' => ['schoolterms.update', $id], 'method' => 'PUT']) !!}
                                    @else
                                        {!! Form::open(['route' => 'schoolterms.store', 'method' => 'POST']) !!}
                                    @endif

                                    @csrf

                                    <div class="form-group">
                                        <label>Name <span class="text-danger">*</span></label>
                                        <input type="text" name="name" class="form-control" value="{{ isset($data) ? $data->name : '' }}" required>
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
                                        <label>Start Date <span class="text-danger">*</span></label>
                                        <input type="date" name="start_date" class="form-control" value="{{ isset($data) ? $data->start_date : '' }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label>End Date <span class="text-danger">*</span></label>
                                        <input type="date" name="end_date" class="form-control" value="{{ isset($data) ? $data->end_date : '' }}" required>
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
            { orderable: false, targets: [5] }
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