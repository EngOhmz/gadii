@extends('layouts.master')

@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Manage Student Levels</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link @if(empty($id)) active show @endif" data-toggle="tab" href="#list">Student Levels List</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if(!empty($id)) active show @endif" data-toggle="tab" href="#tab2">Add/Edit Student Level</a>
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
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!empty($studentlevels))
                                            @foreach($studentlevels as $studentlevel)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $studentlevel->name }}</td>
                                                <td>{{ $studentlevel->status }}</td>
                                                <td>
                                                    <div class="form-inline">
                                                        <a class="list-icons-item text-primary" href="{{ route('studentlevels.edit', $studentlevel->id) }}">
                                                            <i class="icon-pencil7"></i>
                                                        </a>
                                                        &nbsp;
                                                        {!! Form::open(['route' => ['studentlevels.destroy', $studentlevel->id], 'method' => 'delete']) !!}
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
                                        {!! Form::model($data, ['route' => ['studentlevels.update', $id], 'method' => 'PUT']) !!}
                                    @else
                                        {!! Form::open(['route' => 'studentlevels.store', 'method' => 'POST']) !!}
                                    @endif

                                    @csrf

                                    <div class="form-group">
                                        <label>Name <span class="text-danger">*</span></label>
                                        <input type="text" name="name" class="form-control" value="{{ isset($data) ? $data->name : '' }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label>Status <span class="text-danger">*</span></label>
                                        <select name="status" class="form-control" required>
                                            <option value="Active" @if(isset($data) && $data->status == 'Active') selected @endif>Active</option>
                                            <option value="Inactive" @if(isset($data) && $data->status == 'Inactive') selected @endif>Inactive</option>
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
                        </div> <!-- end tab content -->
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
            { orderable: false, targets: [3] }
        ],
        dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
        language: {
            search: '<span>Filter:</span> _INPUT_',
            searchPlaceholder: 'Type to filter...',
            lengthMenu: '<span>Show:</span> _MENU_',
            paginate: {
                'first': 'First',
                'last': 'Last',
                'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;',
                'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;'
            }
        },
    });
</script>
<script src="{{ url('assets/js/plugins/sweetalert/sweetalert.min.js') }}"></script>
@endsection

