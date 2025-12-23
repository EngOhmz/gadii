@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Group Account</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link @if(empty($id)) active show @endif" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Group Account
                                    List</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if(!empty($id)) active show @endif" id="profile-tab2"
                                    data-toggle="tab" href="#profile2" role="tab" aria-controls="profile"
                                    aria-selected="false">New Group Account</a>
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
                                                    aria-label="Browser: activate to sort column ascending"
                                                    style="width: 38.531px;">#</th>

                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 120.484px;">Group ID</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 186.484px;">Name</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Account Group</th>
                                                <th class="always-visible" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 120.1094px;">Actions</th>
                                            </tr>
                                        </thead>
                                         <tbody>
                                            @if(!@empty($group))
                                            @foreach ($group as $row)
                                            
                                            <?php
                                    $bfr=App\Models\AccountCodes::where('account_group',$row->id)->where('disabled','0')->where('added_by',auth()->user()->added_by)->count();
                                    ?>
                                            <tr class="gradeA even" role="row">
                                                <th>{{ $loop->iteration }}</th>
                                                <td>{{$row->group_id}}</td>
                                                <td>{{$row->name}}</td>
                                                <td>@if(!empty($row->classAccount->class_name)) {{$row->classAccount->class_name}} @else {{$row->class}} @endif</td>                                           
                                                                                           

                                                <td>

                                                 <div class="form-inline">
                                                 @if($row->edited == '1')
                                                    <a class="list-icons-item text-primary"
                                                        href="{{ route("group_account.edit", $row->id)}}">
                                                      <i class="icon-pencil7"></i>
                                                    </a>&nbsp

                                                  @if($bfr == '0')
                                              {!! Form::open(['route' => ['group_account.destroy',$row->id], 'method' => 'delete']) !!}
                                {{ Form::button(' <i class="icon-trash"></i>', ['type' => 'submit', 'style' => 'border:none;background: none;', 'class' => 'list-icons-item text-danger', 'title' => 'Delete', 'onclick' => "return confirm('Are you sure?')",]) }}
                                                  {{ Form::close() }}
                                                  @endif
                                                  
                                                    @else
                                                    
                                                     <i class="icon-lock4" title="You cannot edit/delete this account" data-bs-popup="tooltip" data-bs-placement="bottom"></i>
                                                     
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
                                        <h5>Create Group Account</h5>
                                        @else
                                        <h5>Edit Group Account</h5>
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">
                                                @if(isset($id))
                                                {{ Form::model($id, array('route' => array('group_account.update', $id), 'method' => 'PUT')) }}
                                                @else
                                                {{ Form::open(['route' => 'group_account.store']) }}
                                                @method('POST')
                                                @endif



                                                

                                               <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Name</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" name="name" required
                                                            placeholder=""
                                                            value="{{ isset($data) ? $data->name : ''}}"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                               
                                                <div class="form-group row"><label
                                                        class="col-lg-2 col-form-label">Class Account</label>

                                                    <div class="col-lg-8">
                                                     <div class="input-group mb-2">
                                                    <select class="form-control append-button-single-field class" id="account_class" name="class" required>
                                                 <option value="">Select Class Account </option>
                                                  @foreach ($class_account as $class)                                                             
                                                                <option value="{{$class->id}}" @if(isset($data))@if($data->class == $class->id) selected @endif @endif >{{$class->class_name}}</option>
                                                               @endforeach
                                                 
                                                        </select> &nbsp
                                                         <button class="btn btn-outline-secondary" type="button" data-toggle="modal" value="" onclick="model('1','class')"data-target="#appFormModal" href="appFormModal">
                                                <i class="icon-plus-circle2"></i></button>

                                                            </div>
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

 <div class="modal fade " data-backdrop="" id="appFormModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">

        </div>
    </div>

@endsection

@section('scripts')

<link rel="stylesheet" href="{{ asset('assets/datatables/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('assets/datatables/css/buttons.dataTables.min.css') }}">

<script src="{{asset('assets/datatables/js/jquery.dataTables.js')}}"></script>
<script src="{{asset('assets/datatables/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/datatables/js/jszip.min.js')}}"></script>
<script src="{{asset('assets/datatables/js/pdfmake.min.js')}}"></script>
<script src="{{asset('assets/datatables/js/vfs_fonts.js')}}"></script>
<script src="{{asset('assets/datatables/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/datatables/js/buttons.print.min.js')}}"></script>
<script>

      $('.datatable-basic').DataTable(
        {
        dom: 'Bfrtip',

        buttons: [
          {extend: 'copyHtml5',title: 'GROUP ACCOUNT ',  exportOptions:{columns: ':visible :not(.always-visible)'},footer: true},
           {extend: 'excelHtml5',title: 'GROUP ACCOUNT' , exportOptions:{columns: ':visible :not(.always-visible)'}, footer: true},
           {extend: 'csvHtml5',title: 'GROUP ACCOUNT' ,  exportOptions:{columns: ':visible :not(.always-visible)'},footer: true},
            {extend: 'pdfHtml5',title: 'GROUP ACCOUNT',  exportOptions:{columns: ':visible :not(.always-visible)'},footer: true,customize: function(doc) {
doc.content[1].table.widths = [ '10%', '10%', '50%','30%'];
}
},
            {extend: 'print',title: 'GROUP ACCOUNT' , exportOptions:{columns: ':visible :not(.always-visible)'}, footer: true}

                ],
        }
      );
     
    </script>

     <script>
        $(document).ready(function() {

            $(document).on('click', '.add_class', function(e) {
                e.preventDefault();
                console.log(1);
                $.ajax({
                type: 'GET',
                url: '{{ url('gl_setup/save_class') }}',
                data: $('.addClassForm').serialize(),
                dataType: "json",
                success: function(response) {
                    console.log(response['class_account']);

                    var id = response['class_account'].id;
                    var name = response['class_account'].class_name;

                    console.log(id);

                    var option = "<option value='" + id + "'  selected>" + name + " </option>";

                    $('#account_class').append(option);
                    $('#appFormModal').hide();



                }
            });
                
                
            });


        });
    </script>
 <script type="text/javascript">
        function model(id, type) {

            $.ajax({
                type: 'GET',
                url: '{{ url('gl_setup/glModal') }}',
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



    </script>

@endsection