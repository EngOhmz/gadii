@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Key Performance Indicator</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link @if(empty($id)) active show @endif" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Key Performance Indicator
                                    List</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if(!empty($id)) active show @endif" id="profile-tab2"
                                    data-toggle="tab" href="#profile2" role="tab" aria-controls="profile"
                                    aria-selected="false">New Key Performance Indicator</a>
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
                                                    style="width: 126.484px;">Designation</th>
                                               
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Actions</th>
                                            </tr>
                                        </thead>
                                         <tbody>
                                            @if(!@empty($list))
                                            @foreach ($list as $row)
                                            <tr class="gradeA even" role="row">
                                                <th>{{ $loop->iteration }}</th>
                                                <td>{{$row->designation->name}}</td>
                                                                                             

                                                 <td><div class="form-inline">
                                                <a class="list-icons-item text-primary" href="{{ route("kpi.edit", $row->id)}}"> Edit </a>&nbsp&nbsp&nbsp&nbsp
                                        <a class="list-icons-item text-success" href="#" data-toggle="modal" data-target="#appFormModal" onclick="model({{ $row->id }},'view-kpi')"> Show </a>&nbsp

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
                                        <h5>Create Key Performance Indicator</h5>
                                        @else
                                        <h5>Edit Key Performance Indicator</h5>
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">
                                                @if(isset($id))
                                                {{ Form::model($id, array('route' => array('kpi.update', $id), 'method' => 'PUT')) }}
                                                @else
                                                {{ Form::open(['route' => 'kpi.store']) }}
                                                @method('POST')
                                                @endif

                                       <div class="form-group row">
                                        <div class="col-sm-1"></div>
                                    <label class="col-sm-2 control-label">Department
                                        <span class="required" style="color:red;">*</span></label>
                                    <div class="col-sm-6">
                                        <select name="department_id" class="form-control m-b department" style="width:100%" required>
                                            <option value="">Select Department</option>
                                            @if (!empty($department))
                                            @foreach ($department as $dept_name) 
                                            <option value="{{$dept_name->id}}" @if(isset($data)) {{ $data->department_id == $dept_name->id ? 'selected' : ''  }} @endif> {{$dept_name->name}}</option>
                                                   
                                            @endforeach
                                            @endif
                                        </select>
                                   </div>
                                </div>
                                
                                @if(!empty($data->designation_id))
                    <div class="form-group row">
                                        <div class="col-sm-1"></div>
                                    <label class="col-sm-2 control-label">Designation <span class="required" style="color:red;">*</span></label>
                                     <div class="col-sm-6">
                        <select id="designation_id" name="designation_id" class="form-control m-b designation">
                                      <option>Select Designation</option>
                           @if(!empty($designation))
                                                        @foreach($designation as $row)
                                                    <option @if(isset($data)){{ $data->designation_id == $row->id  ? 'selected' : ''}} @endif value="{{$row->id}}">{{$row->name}}</option>
                                                        @endforeach
                                                        @endif
                        </select>
                    </div></div>
             @else
                    <div class="form-group row">
                                        <div class="col-sm-1"></div>
                                    <label class="col-sm-2 control-label">Designation <span class="required" style="color:red;">*</span></label>
                                     <div class="col-sm-6">
                        <select id="designation_id" name="designation_id" class="form-control m-b designation">
                         <option>Select Designation</option>
                        </select>
                    </div></div>
             @endif



                                <div class=""> <p class="form-control-static errors" id="errors" style="text-align:center;color:red;"></p> </div>
                                <br>
                                <!-- Technical Competency Starts ---->
                               

                                           
                                             <button type="button" name="add" class="btn btn-success btn-xs add"><i
                                                                class="fas fa-plus"> Add</i></button><br>
                                                        <br>
                                                        <div class="table-responsive">
                                                        <table class="table table-bordered" id="cart">
                                                            <thead>
                                                                <tr>
                                                                    <th>Key Result Area</th>
                                                                    <th>Key Performance Indicator</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
            
            
                                                           
                                                           
                                                                @if(!empty($id))
                                                                @if(!empty($items))
                                                                @foreach ($items as $i)
                                                                
                                                               
                                                                <tr class="line_items">
                                                                    
                                                                   
                                                <td><textarea class="form-control item_price{{$i->id}}_edit" name="area[]"  required>{{ isset($i) ? $i->area : ''}}</textarea></td>
                                                <td><textarea class="form-control name{{$i->id}}_edit" name="indicator[]" id="editor_ind_edit{{$i->id}}" placeholder="Enter your text...">{{ isset($i) ? $i->indicator : ''}}</textarea></td>
                                        <input type="hidden" name="saved_id[]" class="form-control item_saved{{$i->id}}_edit" value="{{ isset($i) ? $i->id : ''}}" required />
                                        <td><button type="button" name="remove" class="btn btn-danger btn-xs rem" value="{{ isset($i) ? $i->id : ''}}"><i class="icon-trash"></i></button></td>
                                                                </tr>
                                                                
                                                                 @yield('scripts')
                                                                <script>
                                                                var x=<?php echo $i->id ?>;
                                                                console.log(x)
                        ClassicEditor
                                .create( document.querySelector( '#editor_ind_edit'+x ) )
                                .then( editor => {
                                        console.log( editor );
                                } )
                                .catch( error => {
                                        console.error( error );
                                } );
                </script>
                                                
                                                                @endforeach
                                                                @endif
                                                                @endif
                                                
                                                            </tbody>   
                                                        </table>
                                                    </div>
            
            
                                                        <br>
                                               
                                               
                                     
                                      <input type="hidden" class="form-control check"  value="{{ isset($data) ? $id : '' }}">
                                              
                                                <div class="form-group row">
                                                    <div class="col-lg-offset-2 col-lg-12">
                                                        @if(!@empty($id))
                                                        <button class="btn btn-sm btn-primary float-right m-t-n-xs"
                                                            data-toggle="modal" data-target="#myModal"
                                                            type="submit" id="save">Update</button>
                                                        @else
                                                        <button class="btn btn-sm btn-primary float-right m-t-n-xs"
                                                            type="submit" id="save">Save</button>
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
    <div class="modal-dialog modal-lg">
    </div>
</div>

@endsection

@section('scripts')

 <script>
       $('.datatable-basic').DataTable({
            autoWidth: false,
            "columnDefs": [
                {"orderable": false, "targets": [1]}
            ],
           dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
            "language": {
               search: '<span>Filter:</span> _INPUT_',
                searchPlaceholder: 'Type to filter...',
                lengthMenu: '<span>Show:</span> _MENU_',
             paginate: { 'first': 'First', 'last': 'Last', 'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;', 'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;' }
            },
        
        });
    </script>
    
   
    
    <script>
$(document).ready(function() {

    $(document).on('change', '.department', function() {
        var id = $(this).val();
        $.ajax({
            url: '{{url("access_control/findDepartment")}}',
            type: "GET",
            data: {
                id: id
            },
            dataType: "json",
            success: function(response) {
                console.log(response);
                $("#designation_id").empty();
                $("#designation_id").append('<option value="">Select Designation</option>');
                $.each(response,function(key, value)
                {
                 
                    $("#designation_id").append('<option value=' + value.id+ '>' + value.name + '</option>');
                   
                });                      
               
            }

        });

    });






});
</script>
    
    <script>
    $(document).ready(function() {
    
       $(document).on('change', '.designation', function() {
            var id = $(this).val();
             var check= $('.check').val();
                  
            $.ajax({
                url: '{{url("performance/checkDesignation")}}',
                type: "GET",
                data: {
                    id: id,
                  check: check,
                },
                dataType: "json",
                success: function(data) {
                  console.log(data);
                 $('.errors').empty();
                $("#save").attr("disabled", false);
                 if (data != '') {
                $('.errors').append(data);
               $("#save").attr("disabled", true);
    } else {
      
    }
                
           
                }
    
            });
    
        });
    
    
    
    });
    </script>
<script type="text/javascript">
    $(document).ready(function() {
        
        
    
    
        var count = 0;
 
    
        $('.add').on("click", function(e) {
    
            count++;
            var html = '';
            html += '<tr class="line_items">'; 
            html += '<td><textarea class="form-control item_price' + count +'" name="area[]"  required></textarea></td>';
           html += '<td><textarea name="indicator[]"    id="editor_ind' + count +'" placeholder="Enter your text..."></textarea></td>';
            html +='<td><button type="button" name="remove" class="btn btn-danger btn-xs remove"><i class="icon-trash"></i></button></td>';
    
            $("#cart > tbody ").append(html);
            
          
            ClassicEditor.create( document.querySelector( '#editor_ind'+count ) )
                                .then( editor => {
                                        console.log( editor );
                                } )
                                .catch( error => {
                                        console.error( error );
                                } );
           
           
        });
    
        $(document).on('click', '.remove', function() {
            $(this).closest('tr').remove();
           
        });
    
    
        $(document).on('click', '.rem', function() {
            var btn_value = $(this).attr("value");
            $(this).closest('tr').remove();
           $("#cart > tbody ").append(
                '<input type="hidden" name="removed_id[]"  class="form-control name_list" value="' +
                btn_value + '"/>');
           
        });
    
    });
    </script>
 
 <script type="text/javascript">
    function model(id, type) {


        $.ajax({
            type: 'GET',
            url: '{{url("performance/performanceModal")}}',
            data: {
                'id': id,
                'type': type,
            },
            cache: false,
            async: true,
            success: function(data) {
                //alert(data);
                $('.modal-dialog').html(data);
            },
            error: function(error) {
                $('#appFormModal').modal('toggle');

            }
        });

    }
    </script>
@endsection