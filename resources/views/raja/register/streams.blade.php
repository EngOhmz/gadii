@extends('layouts.master')

@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Manage School Streams</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link @if(!isset($id)) active @endif" data-toggle="tab" href="#list">School Streams List</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if(isset($id)) active @endif" data-toggle="tab" href="#tab2">Add/Edit School Stream</a>
                            </li>
                        </ul>

                        <div class="tab-content pt-3">
                            <!-- List Tab -->
                            <div class="tab-pane fade @if(!isset($id)) active show @endif" id="list">
                                <div class="table-responsive">
                                    <table class="table datatable-basic table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Class</th>
                                                <th>Level</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!empty($schoolstreams))
                                            @foreach($schoolstreams as $schoolstream)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $schoolstream->name }}</td>
                                                <td>{{ $schoolstream->class->name ?? 'N/A' }}</td>
                                                <td>{{ $schoolstream->level->name ?? 'N/A' }}</td>
                                                <td>{{ $schoolstream->status }}</td>
                                                <td>
                                                    <div class="form-inline">
                                                        <a class="list-icons-item text-primary" href="{{ route('schoolstreams.edit', $schoolstream->id) }}">
                                                            <i class="icon-pencil7"></i>
                                                        </a>
                                                        &nbsp;
                                                        {!! Form::open(['route' => ['schoolstreams.destroy', $schoolstream->id], 'method' => 'delete']) !!}
                                                        {{ Form::button('<i class="icon-trash"></i>', [
                                                            'type' => 'submit',
                                                            'style' => 'border:none;background: none;',
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

                            <!-- Add/Edit Form -->
                            <div class="tab-pane fade @if(isset($id)) active show @endif" id="tab2">
                                <div class="card-body">
                                    @if(isset($id))
                                        {!! Form::model($data, ['route' => ['schoolstreams.update', $id], 'method' => 'PUT']) !!}
                                    @else
                                        {!! Form::open(['route' => 'schoolstreams.store', 'method' => 'POST']) !!}
                                    @endif

                                    @csrf

                                    <div class="form-group">
                                        <label>Name <span class="text-danger">*</span></label>
                                        <input type="text" name="name" class="form-control" value="{{ isset($data) ? $data->name : '' }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label>Class <span class="text-danger">*</span></label>
                                        <select name="class_id" class="form-control" required>
                                            <option value="">Select Class</option>
                                            @foreach($classes as $class)
                                            <option value="{{ $class->id }}" @if(isset($data) && $data->class_id == $class->id) selected @endif>{{ $class->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Level <span class="text-danger">*</span></label>
                                        <select name="level_id" class="form-control" required>
                                            <option value="">Select Level</option>
                                            @foreach($levels as $level)
                                            <option value="{{ $level->id }}" @if(isset($data) && $data->level_id == $level->id) selected @endif>{{ $level->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Status <span class="text-danger">*</span></label>
                                        <select name="status" class="form-control" required>
                                            <option value="Active" @if(isset($data) && $data->status == 'Active') selected @endif>Active</option>
                                            <option value="Inactive" @if(isset($data) && $data->status == 'Inactive') selected @endif>Inactive</option>
                                        </select>
                                    </div>

                                    <div class="form-group text-right">
                                        <button type="submit" class="btn btn-primary">
                                            @if(isset($id)) Update @else Save @endif
                                        </button>
                                        <a href="{{ route('schoolstreams.index') }}" class="btn btn-secondary">Cancel</a>
                                    </div>

                                    {!! Form::close() !!}
                                </div>
                            </div> <!-- end tab2 -->
                        </div> <!-- end tab-content -->
                    </div> <!-- end card-body -->
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
                first: 'First',
                last: 'Last',
                next: $('html').attr('dir') === 'rtl' ? '←' : '→',
                previous: $('html').attr('dir') === 'rtl' ? '→' : '←'
            }
        }
    });
</script>
<script src="{{ url('assets/js/plugins/sweetalert/sweetalert.min.js') }}"></script>
@endsection
