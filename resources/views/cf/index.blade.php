@extends('layouts.master')
@section('content')
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12 col-sm-12 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>CF</h4>
                        </div>
                        <div class="card-body">
                            <ul class="nav nav-tabs" id="myTab2" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link @if (empty($id)) active show @endif" id="home-tab2"
                                        data-toggle="tab" href="#home2" role="tab" aria-controls="home"
                                        aria-selected="true">CF
                                        List</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link @if (!empty($id)) active show @endif"
                                        id="profile-tab2" data-toggle="tab" href="#profile2" role="tab"
                                        aria-controls="profile" aria-selected="false">New CF</a>
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
                                                        style="width: 176.484px;">File </th>
                                                   
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Engine version: activate to sort column ascending"
                                                        style="width: 141.219px;">Client</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Engine version: activate to sort column ascending"
                                                        style="width: 141.219px;">Department</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Engine version: activate to sort column ascending"
                                                        style="width: 121.219px;">Start Date</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="CSS grade: activate to sort column ascending"
                                                        style="width: 148.1094px;">Assigned To</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="CSS grade: activate to sort column ascending"
                                                        style="width: 138.1094px;">Status</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="CSS grade: activate to sort column ascending"
                                                        style="width: 98.1094px;">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (!@empty($project))
                                                    @foreach ($project as $row)
                                                        <tr class="gradeA even" role="row">
                                                            <td><a href="{{ route('cf.show', $row->id) }}">{{ $row->project_name }} - {{ $row->reff_no }}</a>
                                                            </td>
                                                            
                                                            {{-- <td>{{ $row->category->category_name }}</td> --}}

                                                            @php $a= App\Models\Client::find($row->client_id); @endphp
                                                            @if(!empty($a))
                                                            <td>{{$a->name}}</td>  
                                                            @else
                                                                <td>-</td>
                                                            @endif
                                                            
                                                             @php $dep = App\Models\Departments::find($row->department_id); @endphp
                                                             @if(!empty($dep))
                                                            <td>{{$dep->name}}</td>  
                                                            @else
                                                                <td>-</td>
                                                            @endif
                                                            
                                                            <td>{{ Carbon\Carbon::parse($row->start_date)->format('d/m/Y') }}</td>

                                                            <td>
                                                                <div class="form-inline">
                                                                    <a class="" href="" data-toggle="modal"
                                                                        value="{{ $row->id }}" data-type="view"
                                                                        data-target="#appFormModal"
                                                                        onclick="model({{ $row->id }},'view')">View</a> &nbsp
                                                                    <a class="" href=""
                                                                        data-toggle="modal" value="{{ $row->id }}"
                                                                        data-type="assign" data-target="#appFormModal"
                                                                        onclick="model({{ $row->id }},'assign')"><i
                                                                            class="icon-plus-circle2"></i></a>
                                                                </div>
                                                            </td>

                                                            <td>
                                                                <div class="form-inline">
                                                                    @if ($row->status == 'Cancelled')
                                                                        <div class="badge badge-danger badge-shadow">
                                                                            {{ $row->status }}</div>
                                                                    @elseif($row->status == 'In Progress')
                                                                        <div class="badge badge-info badge-shadow">
                                                                            {{ $row->status }}</div>
                                                                    @elseif($row->status == 'Completed')
                                                                        <span
                                                                            class="badge badge-success badge-shadow">{{ $row->status }}</span>
                                                                    @else
                                                                        <div class="badge badge-warning badge-shadow">
                                                                            {{ $row->status }}</div>
                                                                    @endif
                                                                    <div class="dropdown">&nbsp;
                                                                        <a href="#"
                                                                            class="list-icons-item dropdown-toggle text-teal"
                                                                            data-toggle="dropdown"></a>
                                                                        <div class="dropdown-menu">
                                                                            <a class="nav-link change_status"
                                                                                data-id="{{ $row->id }}"
                                                                                href="{{ route('cf.change_status', ['id' => $row->id, 'status' => 'Started']) }}">Started</a>
                                                                            <a class="nav-link change_status"
                                                                                data-id="{{ $row->id }}"
                                                                                href="{{ route('cf.change_status', ['id' => $row->id, 'status' => 'In Progress']) }}">In
                                                                                Progress</a>
                                                                            <a class="nav-link change_status"
                                                                                data-id="{{ $row->id }}"
                                                                                href="{{ route('cf.change_status', ['id' => $row->id, 'status' => 'On Hold']) }}">On
                                                                                Hold</a>
                                                                            <a class="nav-link change_status"
                                                                                data-id="{{ $row->id }}"
                                                                                href="{{ route('cf.change_status', ['id' => $row->id, 'status' => 'Cancelled']) }}">Cancelled</a>
                                                                            <a class="nav-link change_status"
                                                                                data-id="{{ $row->id }}"
                                                                                href="{{ route('cf.change_status', ['id' => $row->id, 'status' => 'Completed']) }}">Completed</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-inline">
                                                                    <a class="list-icons-item text-primary" title="Edit"
                                                                        href="{{ route('cf.edit', $row->id) }}"><i
                                                                            class="icon-pencil7"></i></a>&nbsp
                                                                    {!! Form::open(['route' => ['cf.destroy', $row->id], 'method' => 'delete']) !!}
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
                                                <h5>Create File</h5>
                                            @else
                                                <h5>Edit File</h5>
                                            @endif
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-12 ">
                                                    @if (isset($id))
                                                        {{ Form::model($id, ['route' => ['cf.update', $id], 'method' => 'PUT']) }}
                                                    @else
                                                        {{ Form::open(['route' => 'cf.store']) }}
                                                        @method('POST')
                                                    @endif
                                          
                                                            <input type="hidden" name="project_no"
                                                                value="{{ isset($data) ? $data->project_no : $reference }}"
                                                                class="form-control" readonly required>
                                                        
                                                    <div class="form-group row">
                                                        <label class="col-lg-2 col-form-label">File Name</label>
                                                        <div class="col-lg-8">
                                                            <input type="text" name="project_name"
                                                                value="{{ isset($data) ? $data->project_name : '' }}"
                                                                class="form-control" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-lg-2 col-form-label">Reference No</label>
                                                        <div class="col-lg-8">
                                                            <input type="text" name="reff_no"
                                                                value="{{ isset($data) ? $data->reff_no : '' }}"
                                                                class="form-control" required>
                                                        </div>
                                                    </div>
                                                     <div class="form-group row">
                                                        <label class="col-lg-2 col-form-label">Send File Date</label>
                                                        <div class="col-lg-8">
                                                            <input type="date" name="send_date"
                                                                value="{{ isset($data) ? $data->send_date : '' }}"
                                                                class="form-control" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-lg-2 col-form-label">Exit Date</label>
                                                        <div class="col-lg-8">
                                                            <input type="date" name="exit_date"
                                                                value="{{ isset($data) ? $data->exit_date : '' }}"
                                                                class="form-control" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-lg-2 col-form-label">Send Location</label>
                                                        <div class="col-lg-8">
                                                            <input type="text" name="send_location"
                                                                value="{{ isset($data) ? $data->send_location : '' }}"
                                                                class="form-control" required>
                                                        </div>
                                                    </div>
                                                   
                                                    <?php $a = 1; ?>
                                                    <div class="form-group row"><label
                                                            class="col-lg-2 col-form-label">File Category</label>
                                                        <div class="col-lg-8">
                                                            <div class="input-group">
                                                        <select class="form-control append-button-single-field account_id" id="category_id" name="category_id"  required>
                                                                    <option value="">Select CF Category</option>
                                                                    @foreach ($category as $row)
                                                                        <option value="{{ $row->id }}"
                                                                            @if (isset($data)) @if ($data->category_id == $row->id) selected @endif
                                                                            @endif
                                                                            >{{ $row->category_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <div class="input-group-append">
                                                                    <button class="btn btn-primary" type="button"
                                                                        data-toggle="modal"
                                                                        onclick="model({{ $a }},'category')"
                                                                        value="{{ $a }}"
                                                                        data-target="#appFormModal"><i
                                                                            class="icon-plus-circle2"></i></button>
                                                                </div>
                                                            </div>&nbsp
                                                        </div>
                                                    </div>

                                                    <!-- <div class="form-group row"><label
                                                            class="col-lg-2 col-form-label">Department</label>
                                                        <div class="col-lg-8">
                                                    <select class="m-b account_id" id="client_id" name="department_id" required>
                                                        <option value="">Select Department</option>
                                                                @foreach ($client as $row)
                                                                <option value="{{ $row->id }}" @if (isset($data)) @if ($data->department_id == $row->id) selected @endif @endif >{{ $row->name }}</option>
                                                                @endforeach
                                                                 </select>
                                                        </div>
                                                    </div>-->
                                                    <div class="form-group row"><label
                                                            class="col-lg-2 col-form-label">Related To</label>
                                                        <div class="col-lg-8">
                                                            <select class="m-b account_id related_class"
                                                                id="related" name="related" required>
                                                                <option value="">Select Related</option>
                                                                <option value="Clients"
                                                                    @if (isset($data)) @if ($data->related == 'Clients') selected @endif
                                                                    @endif >Clients</option>
                                                                <option value="Departments"
                                                                    @if (isset($data)) @if ($data->related== 'Departments') selected @endif
                                                                    @endif >Departments</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div id="projectDiv" style=" display: @if(!empty($data)){{ 'Clients' == $data->related ? 'block' : 'none'  }} @else none @endif;">
                                                    
                                                    
                                                        <div class="form-group row"><label class="col-lg-2 col-form-label">Select Client</label>
                                                            <div class="col-lg-8">
                                                            
                                                              <div class="input-group">
                                                                <select class="form-control append-button-single-field client_id" name="client_id" id="client_id">
                                                                   <option value="">Select Client</option>
                                                                    @if (!empty($clientspj))
                                                                    @foreach ($clientspj as $row)
                                                                    <option value="{{ $row->id }}" @if (isset($data)) @if ($data->client_id == $row->id) selected @endif @endif>
                                                                    {{ $row->name }}</option>
                                                                    @endforeach
                                                                    @endif
                                                                </select>
                                                                
                                                                  <div class="input-group-append">
                                                                <button class="btn btn-primary" type="button"
                                                                    data-toggle="modal" value=""
                                                                    onclick="model('1','client')"
                                                                    data-target="#appFormModal" href="app2FormModal"><i
                                                                        class="icon-plus-circle2"></i></button>
                                                            </div>
                                                            </div>&nbsp
                                                            </div>
                                                        </div>
                                                        </div>
                                                        
                                                    <div id="leadsDiv" style=" display: @if(!empty($data)){{ 'Departments' == $data->related ? 'block' : 'none'  }} @else none @endif;">
                                                        <div class="form-group row"><label class="col-lg-2 col-form-label">Department</label>
                                                            <div class="col-lg-8">
                                                             <div class="input-group">
                                                                <select class="form-control append-button-single-field department_id" id="department_id"name="department_id">
                                                                    <option value="">Select Department</option>
                                                                     @if (!empty($client))
                                                                    @foreach ($client as $row)
                                                                        <option value="{{ $row->id }}"
                                                                            @if (isset($data)) @if ($data->department_id == $row->id) selected @endif
                                                                            @endif
                                                                            >{{ $row->name }}</option>
                                                                    @endforeach
                                                                    @endif
                                                                </select>
                                                            <div class="input-group-append">
                                                                <button class="btn btn-primary" type="button"
                                                                    data-toggle="modal" value=""
                                                                    onclick="model('1','department')"
                                                                    data-target="#appFormModal" href="appFormModal"><i
                                                                        class="icon-plus-circle2"></i></button>
                                                            </div>
                                                            </div>&nbsp
                                                       </div>
                                                       </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-lg-2 col-form-label">Start Date</label>
                                                        <div class="col-lg-8">
                                                            <input type="date" name="start_date" required
                                                                placeholder=""
                                                                value="{{ isset($data) ? $data->start_date : date('Y-m-d') }}"
                                                                class="form-control" required>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-lg-2 col-form-label">Include Due Date</label>
                                                        <div class="col-lg-8">
                                                            <input type="radio" name="due" value="Yes"
                                                                {{ !empty($data) ? ($data->due == 'Yes' ? 'checked' : '') : '' }}
                                                                class="type"> Yes
                                                            <input type="radio" name="due" value="No"
                                                                class=" type"
                                                                {{ !empty($data) ? ($data->due == 'No' ? 'checked' : '') : '' }}>
                                                            No
                                                        </div>
                                                    </div>

                                                    @if (!empty($data->end_date))
                                                        <div class="form-group row end">
                                                            <label class="col-lg-2 col-form-label">End Date</label>
                                                            <div class="col-lg-8">
                                                                <input type="date" name="end_date" required
                                                                    placeholder=""
                                                                    value="{{ isset($data) ? $data->end_date : date('Y-m-d') }}"
                                                                    class="form-control">
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="form-group row end" style="display:none">
                                                            <label class="col-lg-2 col-form-label">End Date</label>
                                                            <div class="col-lg-8">
                                                                <input type="date" name="end_date" required
                                                                    placeholder=""
                                                                    value="{{ isset($data) ? $data->end_date : date('Y-m-d') }}"
                                                                    class="form-control">
                                                            </div>
                                                        </div>
                                                    @endif


                                                    {{-- 
                                                <div class="form-group row"><label
                                                        class="col-lg-2 col-form-label">Billing Type</label>
                                                    <div class="col-lg-8">
                                                <select class="m-b account_id" id="billing_type" name="billing_id" >
                                                    <option value="">Select Billing type</option>                                                    
                                                            @foreach ($billing_type as $row)                                                             
                                                            <option value="{{$row->id}}" @if (isset($data))@if ($data->billing_id == $row->id) selected @endif @endif >{{$row->billing_name}}</option>
                                                               @endforeach
                                                             </select>
                                                    </div>
                                                </div>

                                                  <div class="form-group row">
                                                 <label class="col-lg-2 col-form-label">Fixed Price</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" name="fixed_price" 
                                                            value="{{ isset($data) ? $data->fixed_price : ''}}"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                 <label class="col-lg-2 col-form-label">Estimate Hours</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" name="estimated_hour" 
                                                            value="{{ isset($data) ? $data->estimated_hour : ''}}"
                                                            class="form-control">
                                                    </div>
                                                </div>
 
                                  --}}

                                                    <div class="form-group row"><label
                                                            class="col-lg-2 col-form-label">Status</label>
                                                        <div class="col-lg-8">
                                                            <select class="m-b" id="bank_id" name="status"
                                                                required>

                                                                <option value="">Select</option>

                                                                <option value="Started"
                                                                    @if (isset($data)) @if ($data->status == 'Started') selected @endif
                                                                    @endif >Started</option>

                                                                <option value="In Progress"
                                                                    @if (isset($data)) @if ($data->status == 'In Progress') selected @endif
                                                                    @endif >In Progress</option>

                                                                <option value="On Hold"
                                                                    @if (isset($data)) @if ($data->status == 'On Hold') selected @endif
                                                                    @endif >On Hold</option>

                                                                <option value="Cancelled"
                                                                    @if (isset($data)) @if ($data->status == 'Cancelled') selected @endif
                                                                    @endif >Cancelled</option>
                                                                <option value="Completed"
                                                                    @if (isset($data)) @if ($data->status == 'Completed') selected @endif
                                                                    @endif >Completed</option>

                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-lg-2 col-form-label">Description</label>
                                                        <div class="col-lg-8">
                                                            <textarea class="form-control" name="description">{{ isset($data) ? $data->description : '' }}</textarea>

                                                        </div>
                                                    </div>

                                                    @if (!empty($data))
                                                        <?php
                                                        $list = explode(',', $data->assigned_to);
                                                        ?>
                                                    @endif
                                                    <div class="form-group row">
                                                        <label class="col-lg-2 col-form-label">Assigned To</label>
                                                        <div class="col-lg-8">
                                                            @if (!empty($user))
                                                                <input type="checkbox" name="select_all"
                                                                    id="example-select-all"> Select All <br>
                                                                @foreach ($user as $row)
                                                                    <input name="trans_id[]" type="checkbox"
                                                                        class="checks" value="{{ $row->id }}"
                                                                        @if (!empty($data)) <?php if (in_array("$row->id", $list)) {
                                                                            echo 'checked';
                                                                        } ?> @endif>
                                                                    {{ $row->name }} &nbsp;
                                                                @endforeach
                                                            @endif

                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <div class="col-lg-offset-2 col-lg-12">
                                                            @if (!@empty($id))
                                                             <a class="btn btn-sm btn-danger float-right m-t-n-xs"
                                                                    href="{{ route('cf.index') }}">
                                                                    Cancel
                                                                </a>&nbsp
                                                                
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
    <script type="text/javascript">
        $(document).ready(function() {

            $(document).on('change', '.related_class', function() {


                var id = $(this).val();

                if (id == 'Clients') {
                    $('#projectDiv').show();
                    $('#leadsDiv').hide();
                    $("#department_id").find('option:selected').removeAttr("selected");
                } else if (id == 'Departments') {
                    $('#projectDiv').hide();
                    $('#leadsDiv').show();
                    $("#client_id").find('option:selected').removeAttr("selected");
                }


            });
        });
    </script>
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
        $(document).ready(function() {


            $(document).on('change', '.type', function() {
                var id = $(this).val();
                console.log(id);
                if ($(this).val() == 'Yes') {
                    $('.end').show();
                } else {
                    $('.end').hide();
                }
            });


        });
    </script>

    <script>
        $("#example-select-all").click(function() {
            $("input[type=checkbox]").prop("checked", $(this).prop("checked"));
        });

        $("input[type=checkbox]").click(function() {
            if (!$(this).prop("checked")) {
                $("#example-select-all").prop("checked", false);
            }
        });
    </script>

    <script type="text/javascript">
        function model(id, type) {

            $.ajax({
                type: 'GET',
                url: '{{ url('cf/cfModal') }}',
                data: {
                    'id': id,
                    'type': type,
                },
                cache: false,
                async: true,
                success: function(data) {
                    //alert(data);
                    $('#appFormModal > .modal-dialog').html(data);
                },
                error: function(error) {
                    $('#appFormModal').modal('toggle');

                }
            });

        }
   
        function saveCategory(e) {

            $.ajax({
                type: 'GET',
                url: '{{ url('cf/cf_saveCategory') }}',
                data: $('.addCategoryForm').serialize(),
                dataType: "json",

                success: function(data) {
                    //alert(data);

                    var id = data.id;
                    var name = data.category_name;

                    var option = "<option value='" + id + "'  selected>" + name + " </option>";

                    $('#category_id').append(option);
                    $('#appFormModal').hide();
                    $('.modal-backdrop').remove();
                }

            });

        }


        function saveClient(e) {

            $.ajax({
                type: 'GET',
                url: '{{ url('pos/sales/save_client') }}',
                data: $('.addClientForm').serialize(),
                dataType: "json",
                success: function(response) {
                    console.log(response);

                    var id = response.id;
                    var name = response.name;

                    var option = "<option value='" + id + "'  selected>" + name + " </option>";

                    $('#client_id').append(option);
                    $('#appFormModal').hide();



                }
            });
        }
        

        
        
         function saveDepartment(e) {

            $.ajax({
                type: 'GET',
                url: '{{ url('access_control/save_department') }}',
                data: $('.addDepartmentForm').serialize(),
                dataType: "json",
                success: function(response) {
                    console.log(response);

                    var id = response.id;
                    var name = response.name;

                    var option = "<option value='" + id + "'  selected>" + name + " </option>";

                    $('#department_id').append(option);
                    $('#appFormModal').hide();



                }
            });
        }
        
        
        
        
        
        
    </script>
    
    
@endsection
