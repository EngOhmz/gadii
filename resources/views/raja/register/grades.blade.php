@extends('layouts.master')

@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Manage Grades</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link @if(empty($id)) active @endif" href="#list" data-toggle="tab">Grades List</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if(!empty($id)) active @endif" href="#form" data-toggle="tab">Add/Edit Grade</a>
                            </li>
                        </ul>

                        <div class="tab-content pt-3">
                            <!-- List Tab -->
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="list">
                                <div class="table-responsive">
                                    <table class="table table-striped datatable-basic">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Range</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!empty($gradesregisters))
                                            @foreach($gradesregisters as $grade)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $grade->name }}</td>
                                                <td>{{ $grade->range }}</td>
                                                <td>
                                                    <div class="form-inline">
                                                        <a href="{{ route('gradesregister.edit', $grade->id) }}" class="text-primary">
                                                            <i class="icon-pencil7"></i>
                                                        </a>
                                                        &nbsp;
                                                        {!! Form::open(['route' => ['gradesregister.destroy', $grade->id], 'method' => 'delete']) !!}
                                                        {{ Form::button('<i class="icon-trash"></i>', [
                                                            'type' => 'submit',
                                                            'style' => 'border:none;background:none;',
                                                            'class' => 'text-danger',
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
                            <div class="tab-pane fade @if(!empty($id)) active show @endif" id="form">
                                <div class="card-body">
                                    @if(isset($id))
                                        {!! Form::model($data, ['route' => ['gradesregister.update', $id], 'method' => 'PUT']) !!}
                                    @else
                                        {!! Form::open(['route' => 'gradesregister.store', 'method' => 'POST']) !!}
                                    @endif
                                    @csrf

                                    <div class="form-group">
                                        <label>Name <span class="text-danger">*</span></label>
                                        <input type="text" name="name" class="form-control" value="{{ $data->name ?? '' }}" required placeholder="e.g., A, B, C">
                                    </div>

                                    <div class="form-group">
                                        <label>Range <span class="text-danger">*</span></label>
                                        <input type="text" name="range" class="form-control" value="{{ $data->range ?? '' }}" required placeholder="e.g., 70-100">
                                    </div>

                                    <div class="form-group text-right">
                                        <button type="submit" class="btn btn-primary">
                                            {{ isset($id) ? 'Update' : 'Save' }}
                                        </button>
                                        <a href="{{ route('gradesregister.index') }}" class="btn btn-secondary">Cancel</a>
                                    </div>

                                    {!! Form::close() !!}
                                </div>
                            </div> <!-- End Form -->
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

