@extends('layouts.master')

@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Student Registration</h4>
                    </div>
                    <div class="card-body">
                        <!-- Tabs within a box -->
                        <ul class="nav nav-tabs">
                            <li class="nav-item"><a
                                    class="nav-link @if(empty($id)) active show @endif" href="#home2"
                                    data-toggle="tab">Students List</a>
                            </li>
                            <li class="nav-item"><a class="nav-link @if(!empty($id)) active show @endif"
                                    href="#profile2" data-toggle="tab">Create New Student</a></li>
                            <li class="nav-item">
                                <a class="nav-link" id="importExel-tab"
                                    data-toggle="tab" href="#importExel" role="tab" aria-controls="profile"
                                    aria-selected="false">Import New Students</a>
                            </li>
                        </ul>
                        <div class="tab-content tab-bordered">
                            <!-- ************** general *************-->
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2">
                                <div class="table-responsive">
                                    <table class="table datatable-basic table-striped" id="table-1">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Student Name</th>
                                                <th>Student Gender</th>
                                                <th>Type</th>
                                                <th>Level</th>
                                                <th>Class</th>
                                                <th>Stream</th>
                                                <th>Branch</th>
                                                <th>Parent Name</th>
                                                <th>Parent Phone</th>
                                                <th>Registration Date</th>
                                                <th class="">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!empty($students))
                                            @foreach ($students as $row)
                                            <tr class="gradeA even" role="row">
                                                <th>{{ $loop->iteration }}</th>
                                                <td>{{ $row->student_name }}</td>
                                                <td>{{ $row->gender }}</td>
                                                <td>{{ $row->type }}</td>
                                                
                                                @php $s_lv = App\Models\School\StudentLevel::where('id', $row->school_level_id )->first();  @endphp
                                                
                                                @if(!empty($s_lv))
                                                
                                                 <td>{{ $s_lv->name}}</td>
                                                 
                                                @else
                                                
                                                 <td>{{ $row->school_level_id }}</td>
                                                
                                                
                                                @endif
                                                
                                                
                                                
                                                
                                                @php $cs_lv= App\Models\School\StudentsClass::where('id', $row->class_id)->first();  @endphp
                                                
                                                @if(!empty($cs_lv))
                                                
                                                 <td>{{ $cs_lv->name}}</td>
                                                 
                                                @else
                                                
                                                 <td>{{ $row->class_id }}</td>
                                                
                                                
                                                @endif

                                                <td>{{ $row->stream->name ?? 'N/A' }}</td>
                                                <td>{{ $row->branch->name ?? 'N/A' }}</td>
                                                <td>{{ $row->parent_name }}</td>
                                                <td>{{ $row->parent_phone }}</td>
                                                <td>{{ Carbon\Carbon::parse($row->yearStudy)->format('d/m/Y') }}</td>
                                                <td>
                                                    <div class="form-inline">
                                                        <a href="{{ route('student.edit', $row->id) }}" class="list-icons-item text-primary" title="Edit"><i class="icon-pencil7"></i></a> 
                                                        @canany(['view-promote-student', 'view-disable-student'])
                                                        <div class="dropdown">
                                                            <a href="#" class="list-icons-item dropdown-toggle text-teal" data-toggle="dropdown"><i class="icon-cog6"></i></a>
                                                            <div class="dropdown-menu">
                                                                <a class="nav-link" href="#" data-toggle="modal" data-target="#appFormModal" data-id="{{ $row->id }}" data-type="disable" onclick="model({{ $row->id }}, 'disable')">Disable Student</a>
                                                            </div>
                                                        </div>
                                                        @endcan
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade @if(!empty($id)) active show @endif" id="profile2">
                                <div class="card">
                                    <div class="card-header">
                                        @if(empty($id))
                                        <h5>Create Student</h5>
                                        @else
                                        <h5>Edit Student</h5>
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                @if(isset($id))
                                                {{ Form::model($data, ['route' => ['student.update', $id], 'method' => 'PUT', 'role' => 'form', 'enctype' => 'multipart/form-data']) }}
                                                @else
                                                {{ Form::open(['route' => 'student.store', 'role' => 'form', 'enctype' => 'multipart/form-data']) }}
                                                @method('POST')
                                                @endif

                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">Student Full Name <span class="required">*</span></label>
                                                    <div class="col-lg-8">
                                                        <input type="text" required name="student_name" class="form-control" placeholder="" value="{{ isset($data) ? $data->student_name : '' }}">
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">Student Gender <span class="required">*</span></label>
                                                    <div class="col-lg-8">
                                                        <select class="form-control m-b" name="gender" required>
                                                            <option value="">Select Gender</option>
                                                            <option value="Male" @if(isset($data) && $data->gender == 'Male') selected @endif>Male</option>
                                                            <option value="Female" @if(isset($data) && $data->gender == 'Female') selected @endif>Female</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">Parent Full Name <span class="required">*</span></label>
                                                    <div class="col-lg-8">
                                                        <input type="text" name="parent_name" class="form-control" required placeholder="" value="{{ isset($data) ? $data->parent_name : '' }}">
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">Parent Phone Number <span class="required">*</span></label>
                                                    <div class="col-lg-8">
                                                        <input type="text" name="parent_phone" class="form-control" placeholder="0713000000" required value="{{ isset($data) ? $data->parent_phone : '' }}">
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">School Level <span class="required">*</span></label>
                                                    <div class="col-lg-8">
                                                        <select name="school_level_id" class="form-control m-b level" required>
                                                            <option value="">Select School Level</option>
                                                            @foreach ($levels as $level)
                                                            <option value="{{ $level->id }}" @if(isset($data) && $data->school_level_id == $level->id) selected @endif>{{ $level->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">Class</label>
                                                    <div class="col-lg-8">
                                                        <select class="form-control m-b" name="class_id">
                                                            <option value="">Select Class</option>
                                                            @foreach ($classes as $class)
                                                            <option value="{{ $class->id }}" @if(isset($data) && $data->class_id == $class->id) selected @endif>{{ $class->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">Stream <span class="required">*</span></label>
                                                    <div class="col-lg-8">
                                                        <select name="stream_id" class="form-control m-b" required>
                                                            <option value="">Select Stream</option>
                                                            @foreach ($streams as $stream)
                                                            <option value="{{ $stream->id }}" @if(isset($data) && $data->stream_id == $stream->id) selected @endif>{{ $stream->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">Type <span class="required">*</span></label>
                                                    <div class="col-lg-8">
                                                        <select class="form-control m-b" name="type" required>
                                                            <option value="">Select Type</option>
                                                            <option value="Boarding" @if(isset($data) && $data->type == 'Boarding') selected @endif>Boarding</option>
                                                            <option value="Day" @if(isset($data) && $data->type == 'Day') selected @endif>Day</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">Registration Date <span class="required">*</span></label>
                                                    <div class="col-lg-8">
                                                        <input type="date" required name="yearStudy" class="form-control" value="{{ isset($data) ? $data->yearStudy : '' }}">
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">Branch</label>
                                                    <div class="col-lg-8">
                                                        <select class="form-control m-b" name="branch_id">
                                                            <option value="">Select Branch</option>
                                                            @foreach ($branches as $branch)
                                                            <option value="{{ $branch->id }}" @if(isset($data) && $data->branch_id == $branch->id) selected @endif>{{ $branch->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-lg-offset-2 col-lg-12">
                                                        @if(!empty($id))
                                                        <a href="{{ route('student.index') }}" class="btn btn-sm btn-danger float-right m-t-n-xs">Cancel</a>
                                                        <button class="btn btn-sm btn-primary float-right m-t-n-xs mr-2" type="submit">Update</button>
                                                        @else
                                                        <button class="btn btn-sm btn-primary float-right m-t-n-xs" type="submit">Save</button>
                                                        @endif
                                                    </div>
                                                </div>
                                                {!! Form::close() !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="importExel" role="tabpanel" aria-labelledby="importExel-tab">
                                <div class="card">
                                    <div class="card-header">
                                        <form action="{{ route('student.sample') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <button class="btn btn-success">Download Sample</button>
                                        </form>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="container mt-5 text-center">
                                                    <h4 class="mb-4">Import Excel & CSV File</h4>
                                                    <form action="{{ route('student.import') }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="form-group mb-4">
                                                            <div class="custom-file text-left">
                                                                <input type="file" name="file" class="form-control" id="customFile" required>
                                                            </div>
                                                        </div>
                                                        <button class="btn btn-primary">Import Students</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- discount Modal -->
<div class="modal fade" id="appFormModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog"></div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
    function model(id, type) {
        let url = '{{ route("student.show", ":id") }}';
        url = url.replace(':id', id);

        $.ajax({
            type: 'GET',
            url: url,
            data: {
                'type': type,
            },
            cache: false,
            async: true,
            success: function(data) {
                $('.modal-dialog').html(data);
            },
            error: function(error) {
                $('#appFormModal').modal('toggle');
            }
        });
    }
</script>
@endsection