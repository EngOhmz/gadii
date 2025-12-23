@extends('layouts.master')


@section('content')
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12 col-sm-6 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Ticket</h4>
                        </div>
                        <div class="card-body">
                            <ul class="nav nav-tabs" id="myTab2" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link @if (empty($id)) active show @endif" id="home-tab2"
                                        data-toggle="tab" href="#home2" role="tab" aria-controls="home"
                                        aria-selected="true">Ticket
                                        List</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link @if (!empty($id)) active show @endif"
                                        id="profile-tab2" data-toggle="tab" href="#profile2" role="tab"
                                        aria-controls="profile" aria-selected="false">New Ticket</a>
                                </li>

                            </ul>
                            <div class="tab-content tab-bordered" id="myTab3Content">
                                <div class="tab-pane fade @if (empty($id)) active show @endif"
                                    id="home2" role="tabpanel" aria-labelledby="home-tab2">
                                    <div class="table-responsive">
                                        <!--
                                            <table border="0" cellspacing="15" cellpadding="20">
                                            <tbody>
                                
                                                <tr>
                                                                 <td></td><td></td><td></td>
                                                        <td><b>Date Filter</b></td><td></td><td><b>Minimum date:</b></td>
                                                            <td><input type="text" id="min" name="min"   class="form-control "></td>
                                                       
                                                            <td><b>Maximum date:</b></td>
                                                            <td><input type="text" id="max" name="max"   class="form-control "></td>
                                                        </tr>
                                                    </tbody></table>
                                                -->
                                                    <table class="table datatable-basic table-striped">
                                            <thead>
                                                <tr>


                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Platform(s): activate to sort column ascending"
                                                        style="width: 126.484px;">Ticket Code</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Platform(s): activate to sort column ascending"
                                                        style="width: 186.484px;">Subject</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Engine version: activate to sort column ascending"
                                                        style="width: 141.219px;">Date</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Engine version: activate to sort column ascending"
                                                        style="width: 141.219px;">Reporter</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="CSS grade: activate to sort column ascending"
                                                        style="width: 98.1094px;">Department</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="CSS grade: activate to sort column ascending"
                                                        style="width: 98.1094px;">Tags</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="CSS grade: activate to sort column ascending"
                                                        style="width: 98.1094px;">Status</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="CSS grade: activate to sort column ascending"
                                                        style="width: 98.1094px;">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (!@empty($tickets))
                                                    @foreach ($tickets as $row)
                                                        <tr class="gradeA even" role="row">
                                                            <td><a href="{{ route('ticket.show', $row->id) }}"> {{ $row->ticket_code }}</a></td>
                                                            <td>{{ $row->subject }}</td>
                                                            <td>{{ $row->created_at->format('Y-m-d') }}</td>
                                                            @php $reporter = App\Models\User::find($row->reporter);  @endphp
                                                            <td>{{ $reporter->name }}</td>
                                                            @php $department = App\Models\Departments::find($row->departments_id);  @endphp
                                                            <td>{{ $department->name }}</td>
                                                            <td>{{ $row->tags }}</td>
                                                            <td>{{ $row->status }}</td>

                                                            <td>

                                                                <div class="form-inline">


                                                                    <a class="list-icons-item text-primary" title="Edit"
                                                                        href="{{ route('ticket.edit', $row->id) }}"><i
                                                                            class="icon-pencil7"></i></a>&nbsp

                                                                    {!! Form::open(['route' => ['ticket.destroy', $row->id], 'method' => 'delete']) !!}
                                                                    {{ Form::button('<i class="icon-trash"></i>', ['type' => 'submit', 'style' => 'border:none;background: none;', 'class' => 'list-icons-item text-danger', 'title' => 'Delete', 'onclick' => "return confirm('Are you sure?')"]) }}
                                                                    {{ Form::close() }}
                                                                    &nbsp



                                                                </div>





                                                            </td>
                                                        </tr>
                                                    @endforeach

                                                @endif

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade @if (!empty($id)) active show @endif"
                                    id="profile2" role="tabpanel" aria-labelledby="profile-tab2">

                                    <div class="card">
                                        <div class="card-header">
                                            @if (empty($id))
                                                <h5>Create Ticket</h5>
                                            @else
                                                <h5>Edit Ticket</h5>
                                            @endif
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-12 ">
                                                    @if (isset($id))
                                                        {{ Form::model($id, ['route' => ['ticket.update', $id], 'method' => 'PUT']) }}
                                                    @else
                                                        {{ Form::open(['route' => 'ticket.store']) }}
                                                        @method('POST')
                                                    @endif



                                                    <div class="form-group row">
                                                        <label class="col-lg-2 col-form-label">Tickect Code</label>
                                                        <div class="col-lg-8">
                                                            <input type="text" name="ticket_code"
                                                                value="{{ isset($data) ? $data->ticket_code : '' }}"
                                                                class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-lg-2 col-form-label">Subjecte</label>
                                                        <div class="col-lg-8">
                                                            <input type="text" name="subject"
                                                                value="{{ isset($data) ? $data->subject : '' }}"
                                                                class="form-control">
                                                        </div>
                                                    </div>


                                                    <div class="form-group row"><label
                                                            class="col-lg-2 col-form-label">Reporter</label>
                                                        <div class="col-lg-8">
                                                            <select class="m-b account_id" id="reporter" name="reporter"
                                                                required>
                                                                <option value="">Select Reporter</option>
                                                                @foreach ($users as $row)
                                                                    <option value="{{ $row->id }}"
                                                                        @if (isset($data)) @if ($data->reporter == $row->id) selected @endif
                                                                        @endif >{{ $row->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row"><label
                                                            class="col-lg-2 col-form-label">Select Project</label>
                                                        <div class="col-lg-8">
                                                            <select class="m-b account_id" id="project_id"
                                                                name="project_id">
                                                                <option value="">Select Project</option>
                                                                @foreach ($project as $row)
                                                                    <option value="{{ $row->id }}"
                                                                        @if (isset($data)) @if ($data->project_id == $row->id) selected @endif
                                                                        @endif >{{ $row->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row"><label
                                                            class="col-lg-2 col-form-label">Select Priority</label>
                                                        <div class="col-lg-8">
                                                            <select class="m-b account_id" id="priority" name="priority"
                                                                required>
                                                                <option value="">Select Priority</option>
                                                                <option value="Ok"
                                                                    @if (isset($data)) @if ($data->project_id == 'Ok') selected @endif
                                                                    @endif >Ok</option>
                                                                <option value="Low"
                                                                    @if (isset($data)) @if ($data->project_id == 'Low') selected @endif
                                                                    @endif >Low</option>
                                                                <option value="Medium"
                                                                    @if (isset($data)) @if ($data->project_id == 'Medium') selected @endif
                                                                    @endif >Medium</option>
                                                                <option value="High"
                                                                    @if (isset($data)) @if ($data->project_id == 'High') selected @endif
                                                                    @endif >High</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row"><label
                                                            class="col-lg-2 col-form-label">Select Department</label>
                                                        <div class="col-lg-8">
                                                            <select class="m-b account_id" id="departments_id"
                                                                name="departments_id" required>
                                                                <option value="">Select Department</option>
                                                                @foreach ($departments as $row)
                                                                    <option value="{{ $row->id }}"
                                                                        @if (isset($data)) @if ($data->departments_id == $row->id) selected @endif
                                                                        @endif >{{ $row->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-lg-2 col-form-label">Tags</label>
                                                        <div class="col-lg-8">
                                                            <input type="text" name="tags" required placeholder=""
                                                                value="{{ isset($data) ? $data->tags : '' }}"
                                                                class="form-control">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-lg-2 col-form-label">Attachment</label>
                                                        <div class="col-lg-8">
                                                            <input type="file" name="upload_file"
                                                                value="{{ isset($data) ? $data->upload_file : '' }}"
                                                                class="form-control">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-lg-2 col-form-label">Ticket Message</label>
                                                        <div class="col-lg-8">
                                                            <textarea class="form-control" name="body">{{ isset($data) ? $data->body : '' }}</textarea>

                                                        </div>
                                                    </div>

                                                    <div class="form-group row"><label
                                                            class="col-lg-2 col-form-label">Select Permission</label>
                                                        <div class="col-lg-8">
                                                            <select class="m-b account_id" id="permission"
                                                                name="permission" required>
                                                                <option value="">Select Permission</option>
                                                                <option value="Everyone"
                                                                    @if (isset($data)) @if ($data->permission == 'Everyone') selected @endif
                                                                    @endif >Everyone</option>
                                                                <option value="Customize Permission"
                                                                    @if (isset($data)) @if ($data->permission == 'Customize Permission') selected @endif
                                                                    @endif >Customize Permission
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    
                                                    
                                                    
                                                   

                                                    <div class="form-group row">
                                                        <div class="col-lg-offset-2 col-lg-12">
                                                            @if (!@empty($id))
                                                                <button class="btn btn-sm btn-primary float-right m-t-n-xs"
                                                                    data-toggle="modal" data-target="#myModal"
                                                                    type="submit">Update</button>
                                                            @else
                                                                <button class="btn btn-sm btn-primary float-right m-t-n-xs"
                                                                    type="submit">Save</button>
                                                            @endif
                                                        </div>
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
                </div>
            </div>

        </div>
    </section>
@endsection

@section('scripts')
    <script>
        $('.datatable-basic').DataTable({
            autoWidth: false,
            "columnDefs": [{
                "targets": [3]
            }],
            dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
            "language": {
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
    <script>
        var minDate, maxDate;

        // Custom filtering function which will search data in column four between two values
        $.fn.dataTable.ext.search.push(
            function(settings, data, dataIndex) {
                var min = minDate.val();
                var max = maxDate.val();
                var date = new Date(data[5]);

                if (
                    (min === null && max === null) ||
                    (min === null && date <= max) ||
                    (min <= date && max === null) ||
                    (min <= date && date <= max)
                ) {
                    return true;
                }
                return false;
            }
        );
    </script>
    <script>
        $(document).ready(function() {

            $(document).on('change', '.account_id', function() {
                var id = $(this).val();
                console.log(id);

                $.ajax({
                    url: '{{ url('gl_setup/findSupplier') }}',
                    type: "GET",
                    data: {
                        id: id,
                    },
                    dataType: "json",
                    success: function(data) {
                        console.log(data);
                        $("#supplier").css("display", "none");
                        if (data == 'OK') {
                            $("#supplier").css("display", "block");
                        }


                    }

                });

            });

        });
    </script>
    <script src="{{ url('assets/js/plugins/sweetalert/sweetalert.min.js') }}"></script>
    
    
   
@endsection
