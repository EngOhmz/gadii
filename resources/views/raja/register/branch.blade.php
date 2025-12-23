@extends('layouts.master')

@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Manage School Branches</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link @if(empty($id)) active @endif" href="#list" data-toggle="tab">School Branches List</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if(!empty($id)) active @endif" href="#tab2" data-toggle="tab">Add/Edit School Branch</a>
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
                                            @if(!empty($schoolbranches))
                                            @foreach($schoolbranches as $schoolbranch)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $schoolbranch->name }}</td>
                                                <td>{{ $schoolbranch->status }}</td>
                                                <td>
                                                    <div class="form-inline">
                                                        <a class="list-icons-item text-primary" href="{{ route('schoolbranch.edit', $schoolbranch->id) }}">
                                                            <i class="icon-pencil7"></i>
                                                        </a>
                                                        &nbsp;
                                                        {!! Form::open(['route' => ['schoolbranch.destroy', $schoolbranch->id], 'method' => 'delete']) !!}
                                                        {{ Form::button('<i class="icon-trash"></i>', [
                                                            'type' => 'submit',
                                                            'class' => 'list-icons-item text-danger',
                                                            'style' => 'border:none; background:none;',
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

                            <!-- Create/Edit Form Tab -->
                            <div class="tab-pane fade @if(!empty($id)) active show @endif" id="tab2">
                                <div class="card-body">
                                    @if(isset($id))
                                        {!! Form::model($data, ['route' => ['schoolbranch.update', $id], 'method' => 'PUT']) !!}
                                    @else
                                        {!! Form::open(['route' => 'schoolbranch.store', 'method' => 'POST']) !!}
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
                                        <button type="submit" class="btn btn-primary">
                                            @if(!empty($id)) Update @else Save @endif
                                        </button>
                                        <a href="{{ route('schoolbranch.index') }}" class="btn btn-secondary">Cancel</a>
                                    </div>

                                    {!! Form::close() !!}
                                </div>
                            </div> <!-- End tab2 -->
                        </div> <!-- End tab-content -->
                    </div> <!-- End card-body -->
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
        columnDefs: [{ orderable: false, targets: [3] }],
        dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
        language: {
            search: '<span>Filter:</span> _INPUT_',
            searchPlaceholder: 'Type to filter...',
            lengthMenu: '<span>Show:</span> _MENU_',
            paginate: {
                first: 'First',
                last: 'Last',
                next: $('html').attr('dir') === 'rtl' ? '&larr;' : '&rarr;',
                previous: $('html').attr('dir') === 'rtl' ? '&rarr;' : '&larr;'
            }
        }
    });
</script>
<script src="{{ url('assets/js/plugins/sweetalert/sweetalert.min.js') }}"></script>
@endsection

