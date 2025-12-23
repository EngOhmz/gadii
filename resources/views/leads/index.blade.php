@extends('layouts.master')
@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Leads</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link @if(empty($id)) active show @endif" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Leads
                                    List</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if(!empty($id)) active show @endif" id="profile-tab2"
                                    data-toggle="tab" href="#profile2" role="tab" aria-controls="profile"
                                    aria-selected="false">New Leads</a>
                            </li>

                        </ul>
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">
                                <div class="table-responsive">

                                    <table class="table datatable-basic table-striped">
                                        <thead>
                                            <tr>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 126.484px;">Title</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 136.484px;">Contact Name</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 121.219px;">Phone</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Source</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Status</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Converted To Client</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 128.1094px;">Assigned to</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!@empty($leads))
                                            @foreach ($leads as $row)
                                            <tr class="gradeA even" role="row">
                                                <td><a href="{{ route("leads.show",$row->id)}}" class="nav-link">{{$row->lead_name}}</a></td>
                                                <td>{{$row->contact_name}}</td>
                                                <td>{{$row->phone}}</td>
                                                <td>{{$row->source->lead_source}}</td>
                                                <td>{{$row->status->lead_status}}</td>

                                                @if($row->change_status == 0)
                                                <td>Not Yet</td>
                                                @else
                                                <td>Yes</td>
                                                @endif

                                                <td>{{$row->assign->name}}</td>

                                                <td>

                                                    <div class="form-inline">

                                                        <a class="list-icons-item text-primary" title="Edit" href="{{ route("leads.edit",$row->id)}}"><i class="icon-pencil7"></i></a>&nbsp

                                                        {!! Form::open(['route' => ['leads.destroy',$row->id], 'method' => 'delete']) !!}
                                                        {{ Form::button('<i class="icon-trash"></i>', ['type' => 'submit', 'style' => 'border:none;background: none;', 'class' => 'list-icons-item text-danger', 'title' => 'Delete', 'onclick' => "return confirm('Are you sure?')"]) }}
                                                        {{ Form::close() }}
                                                        &nbsp
                                                        @if ($row->change_status == 0)
                                                        <div class="dropdown">
                                                            <a href="#"
                                                                class="list-icons-item dropdown-toggle text-teal"
                                                                data-toggle="dropdown"><i
                                                                    class="icon-cog6"></i></a>
                                                            <div class="dropdown-menu">

                                                                <a class="nav-link" id="profile-tab2"
                                                                    href="{{ route('leads.change_status', $row->id) }}"
                                                                    role="tab" aria-selected="false"
                                                                    onclick="return confirm('Are you sure?')">Convert To Client
                                                                </a>

                                                            </div>
                                                        </div>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade @if(!empty($id)) active show @endif" id="profile2" role="tabpanel"
                                aria-labelledby="profile-tab2">

                                <div class="card">
                                    <div class="card-header">
                                        @if(empty($id))
                                        <h5>Create Leads</h5>
                                        @else
                                        <h5>Edit Leads</h5>
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">
                                                @if(isset($id))
                                                {{ Form::model($id, array('route' => array('leads.update', $id), 'method' => 'PUT')) }}
                                                @else
                                                {{ Form::open(['route' => 'leads.store']) }}
                                                @method('POST')
                                                @endif

                                                <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Title <span class="text-danger">*</span></label>
                                                    <div class="col-lg-4">
                                                        <input type="text" name="lead_name"
                                                            value="{{ isset($data) ? $data->lead_name : ''}}"
                                                            class="form-control" required>
                                                    </div>
                                                    <label class="col-lg-2 col-form-label">Organization Name</label>
                                                    <div class="col-lg-4">
                                                        <input type="text" name="organization"
                                                            value="{{ isset($data) ? $data->organization : ''}}"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Contact Name <span class="text-danger">*</span></label>
                                                    <div class="col-lg-4">
                                                        <input type="text" name="contact_name"
                                                            value="{{ isset($data) ? $data->contact_name : ''}}"
                                                            class="form-control" required>
                                                    </div>
                                                    <label class="col-lg-2 col-form-label">Phone Number <span class="text-danger">*</span></label>
                                                    <div class="col-lg-4">
                                                        <input type="text" name="phone"
                                                            value="{{ isset($data) ? $data->phone : ''}}"
                                                            class="form-control" required>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Email <span class="text-danger">*</span></label>
                                                    <div class="col-lg-4">
                                                        <input type="text" name="email"
                                                            value="{{ isset($data) ? $data->email : ''}}"
                                                            class="form-control" required>

                                                    </div>

                                                    <label class="col-lg-2 control-label">Address </label>
                                                    <div class="col-lg-4">
                                                        <textarea name="address" class="form-control">{{ isset($data) ? $data->address : ''}}</textarea>
                                                    </div>
                                                </div>

                                                <?php
                                                $a = 1;
                                                $b = 1;
                                                ?>

                                                <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Lead Source <span class="text-danger">*</span></label>
                                                    <div class="col-lg-4">
                                                        <select class="m-b source_id" id="source_id" name="source_id" required>
                                                            <option value="">Select Lead Source</option>
                                                            @foreach ($source as $row)
                                                            <option value="{{$row->id}}" @if(isset($data))@if($data->source_id == $row->id) selected @endif @endif >{{$row->lead_source}}</option>
                                                            @endforeach
                                                        </select>
                                                        {{--<div class="input-group-append">
                                                            <button class="btn btn-primary" type="button" data-toggle="modal" onclick="model({{ $a }},'source')" value="{{ $a}}" data-target="#appFormModal"><i class="icon-plus-circle2"></i></button>
                                                        </div>--}}
                                                    </div>

                                                    <label class="col-lg-2 col-form-label">Select Lead Status <span class="text-danger">*</span></label>
                                                    <div class="col-lg-4">
                                                        <div class="input-group">
                                                            <select class="m-b statu_id" id="status_id" name="status_id" required>
                                                                <option value="">Select Lead Status</option>
                                                                @foreach ($status as $row)
                                                                <option value="{{$row->id}}" @if(isset($data))@if($data->status_id == $row->id) selected @endif @endif >{{$row->lead_status}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        {{--<div class="input-group-append">
                                                            <button class="btn btn-primary" type="button" data-toggle="modal" onclick="model({{ $b }},'status')" value="{{ $b}}" data-target="#appFormModal"><i class="icon-plus-circle2"></i></button>
                                                        </div>--}}
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Assigned To <span class="text-danger">*</span></label>
                                                    <div class="col-lg-4">
                                                        <select class="m-b assign" id="assign" name="assigned_to" required>
                                                            <option value="">Select </option>
                                                            @foreach ($user as $row)
                                                            <option value="{{$row->id}}" @if(isset($data))@if($data->assigned_to == $row->id) selected @endif @endif >{{$row->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>


                                                    <label class="col-lg-2 control-label">Country <span class="text-danger">*</span></label>
                                                    <div class="col-lg-4">
                                                        <select class="m-b country_id" id="country_id" name="country_id" required>
                                                            <option value="">Select Country</option>
                                                            @foreach ($country as $row)
                                                            <option value="{{$row->id}}" @if(isset($data))@if($data->country_id == $row->id) selected @endif @endif >{{$row->value}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-lg-2 control-label">Language</label>
                                                    <div class="col-lg-4">
                                                        <select class="m-b language_id" id="language_id" name="language_id">
                                                            <option value="">Select Language</option>
                                                            @foreach ($lang as $row)
                                                            <option value="{{$row->code}}" @if(isset($data))@if($data->language_id == $row->code) selected @endif @endif ><?php echo  ucfirst($row->name) ?></option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <label class="col-lg-2 control-label">Twitter URL </label>

                                                    <div class="col-lg-4">
                                                        <input type="text" class="form-control" value="{{ isset($data) ? $data->twitter : ''}}" name="twitter">
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-lg-2 control-label">Skype ID </label>
                                                    <div class="col-lg-4">
                                                        <input type="text" class="form-control" value="{{ isset($data) ? $data->skype : ''}}" name="skype">
                                                    </div>

                                                    <label class="col-lg-2 control-label">Facebook URL </label>
                                                    <div class="col-lg-4">
                                                        <input type="text" class="form-control" value="{{ isset($data) ? $data->facebook : ''}}" name="facebook">
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-lg-2 control-label">Notes </label>
                                                    <div class="col-lg-8">
                                                        <textarea name="notes" class="form-control textarea">{{ isset($data) ? $data->notes : ''}}</textarea>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-lg-offset-2 col-lg-12">
                                                        @if(!@empty($id))
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

<!-- discount Modal -->
<div class="modal fade" id="appFormModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
    </div>
</div>

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

<script type="text/javascript">
    function model(id, type) {

        $.ajax({
            type: 'GET',
            url: '{{url("leadsModal")}}',
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


    function saveSource(e) {
        var form = $('#addSourceForm').serialize();
        $.ajax({
            type: 'GET',
            url: '{{url("addSource")}}',
            data: $('#addSourceForm').serialize(),

            dataType: "json",
            success: function(response) {
                console.log(response);

                var id = response.id;
                var name = response.lead_source;

                var option = "<option value='" + id + "'  selected>" + name + " </option>";

                $('#source_id').append(option);
                $('#appFormModal').hide();
                $('.modal-backdrop').remove();


            }
        });
    }



    function saveStatus(e) {
        var form = $('#addStatusForm').serialize();
        $.ajax({
            type: 'GET',
            url: '{{url("addStatus")}}',
            data: $('#addStatusForm').serialize(),

            dataType: "json",
            success: function(response) {
                console.log(response);

                var id = response.id;
                var name = response.lead_status;

                var option = "<option value='" + id + "'  selected>" + name + " </option>";

                $('#status_id').append(option);
                $('#appFormModal').hide();
                $('.modal-backdrop').remove();

            }
        });
    }
</script>

@endsection
