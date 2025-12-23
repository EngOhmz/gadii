@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Indicator</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link @if(empty($id)) active show @endif" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Indicator
                                    List</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if(!empty($id)) active show @endif" id="profile-tab2"
                                    data-toggle="tab" href="#profile2" role="tab" aria-controls="profile"
                                    aria-selected="false">New Indicator</a>
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
                                                    style="width: 126.484px;">Department</th>
                                               
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
                                                <td>{{$row->department->name}}</td>
                                                                                             

                                                 <td><div class="form-inline">
                                                <a class="list-icons-item text-primary" href="{{ route("indicator.edit", $row->id)}}"> Edit </a>&nbsp&nbsp&nbsp&nbsp
                                        <a class="list-icons-item text-success" href="#" data-toggle="modal" data-target="#appFormModal" onclick="model({{ $row->id }},'view')"> Show </a>&nbsp

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
                                        <h5>Create Indicator</h5>
                                        @else
                                        <h5>Edit Indicator</h5>
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">
                                                @if(isset($id))
                                                {{ Form::model($id, array('route' => array('indicator.update', $id), 'method' => 'PUT')) }}
                                                @else
                                                {{ Form::open(['route' => 'indicator.store']) }}
                                                @method('POST')
                                                @endif

                                       <div class="form-group row">
                                        <div class="col-sm-1"></div>
                                    <label class="col-sm-2 control-label">Department
                                        <span class="required" style="color:red;">*</span></label>
                                    <div class="col-sm-6">
                                        <select name="department_id" class="form-control m-b department" style="width:100%" required>
                                            <option value="">Select</option>
                                            @if (!empty($department))
                                            @foreach ($department as $dept_name) 
                                            <option value="{{$dept_name->id}}" @if(isset($data)) {{ $data->department_id == $dept_name->id ? 'selected' : ''  }} @endif> {{$dept_name->name}}</option>
                                                   
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    
                                </div>
                                <div class=""> <p class="form-control-static errors" id="errors" style="text-align:center;color:red;"></p> </div>
                                <br>
                                <!-- Technical Competency Starts ---->
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="panel-title" style="margin-left: 8px;">Technical Competencies</h5>
                                            </div>
                                           
                                            <div class="card-body">
                                               
                                                <div class="form-group row" id="border-none">
                                                    <label
                                                        class="col-sm-7 control-label">Customer Experience Management</label>
                                                    <div class="col-sm-5">
                                                        <select name="customer_experiece_management" class="form-control m-b tech">
                                                            <option value="">Select</option>
                                                            <option value="1" @if(isset($data)) {{ $data->customer_experiece_management == '1' ? 'selected' : ''  }} @endif> Beginner</option>
                                                            <option value="2" @if(isset($data)) {{ $data->customer_experiece_management == '2' ? 'selected' : ''  }} @endif> Intermediate</option>
                                                            <option value="3" @if(isset($data)) {{ $data->customer_experiece_management == '3' ? 'selected' : ''  }} @endif> Advanced</option>
                                                            <option value="4" @if(isset($data)) {{ $data->customer_experiece_management == '4' ? 'selected' : ''  }} @endif> Expert</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row" id="border-none">
                                                    <label
                                                        class="col-sm-7 control-label">Marketing </label>
                                                    <div class="col-sm-5">
                                                        <select name="marketing" class="form-control m-b tech">
                                                            <option value="">Select</option>
                                                            <option value="1" @if(isset($data)) {{ $data->marketing == '1' ? 'selected' : ''  }} @endif> Beginner</option>
                                                            <option value="2" @if(isset($data)) {{ $data->marketing == '2' ? 'selected' : ''  }} @endif> Intermediate</option>
                                                            <option value="3" @if(isset($data)) {{ $data->marketing == '3' ? 'selected' : ''  }} @endif> Advanced</option>
                                                            <option value="4" @if(isset($data)) {{ $data->marketing == '4' ? 'selected' : ''  }} @endif> Expert</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row" id="border-none">
                                                    <label
                                                        class="col-sm-7 control-label">Management </label>
                                                    <div class="col-sm-5">
                                                        <select name="management" class="form-control m-b tech">
                                                             <option value="">Select</option>
                                                            <option value="1" @if(isset($data)) {{ $data->management == '1' ? 'selected' : ''  }} @endif> Beginner</option>
                                                            <option value="2" @if(isset($data)) {{ $data->management == '2' ? 'selected' : ''  }} @endif> Intermediate</option>
                                                            <option value="3" @if(isset($data)) {{ $data->management == '3' ? 'selected' : ''  }} @endif> Advanced</option>
                                                            <option value="4" @if(isset($data)) {{ $data->management == '4' ? 'selected' : ''  }} @endif> Expert</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row" id="border-none">
                                                    <label
                                                        class="col-sm-7 control-label">Administration  </label>
                                                    <div class="col-sm-5">
                                                        <select name="administration" class="form-control m-b tech">
                                                          <option value="">Select</option>
                                                            <option value="1" @if(isset($data)) {{ $data->administration == '1' ? 'selected' : ''  }} @endif> Beginner</option>
                                                            <option value="2" @if(isset($data)) {{ $data->administration == '2' ? 'selected' : ''  }} @endif> Intermediate</option>
                                                            <option value="3" @if(isset($data)) {{ $data->administration == '3' ? 'selected' : ''  }} @endif> Advanced</option>
                                                            <option value="4" @if(isset($data)) {{ $data->administration == '4' ? 'selected' : ''  }} @endif> Expert</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row" id="border-none">
                                                    <label
                                                        class="col-sm-7 control-label">Presentation Skill </label>
                                                    <div class="col-sm-5">
                                                        <select name="presentation_skill" class="form-control m-b tech">
                                                            <option value="">Select</option>
                                                            <option value="1" @if(isset($data)) {{ $data->presentation_skill == '1' ? 'selected' : ''  }} @endif> Beginner</option>
                                                            <option value="2" @if(isset($data)) {{ $data->presentation_skill== '2' ? 'selected' : ''  }} @endif> Intermediate</option>
                                                            <option value="3" @if(isset($data)) {{ $data->presentation_skill == '3' ? 'selected' : ''  }} @endif> Advanced</option>
                                                            <option value="4" @if(isset($data)) {{ $data->presentation_skill == '4' ? 'selected' : ''  }} @endif> Expert</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row" id="border-none">
                                                    <label
                                                        class="col-sm-7 control-label">Quality Of Work</label>
                                                    <div class="col-sm-5">
                                                        <select name="quality_of_work" class="form-control m-b tech">
                                                         <option value="">Select</option>
                                                            <option value="1" @if(isset($data)) {{ $data->quality_of_work == '1' ? 'selected' : ''  }} @endif> Beginner</option>
                                                            <option value="2" @if(isset($data)) {{ $data->quality_of_work== '2' ? 'selected' : ''  }} @endif> Intermediate</option>
                                                            <option value="3" @if(isset($data)) {{ $data->quality_of_work == '3' ? 'selected' : ''  }} @endif> Advanced</option>
                                                            <option value="4" @if(isset($data)) {{ $data->quality_of_work == '4' ? 'selected' : ''  }} @endif> Expert</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row" id="border-none">
                                                    <label
                                                        class="col-sm-7 control-label">Efficiency</label>
                                                    <div class="col-sm-5">
                                                        <select name="efficiency" class="form-control m-b tech">
                                                             <option value="">Select</option>
                                                            <option value="1" @if(isset($data)) {{ $data->efficiency == '1' ? 'selected' : ''  }} @endif> Beginner</option>
                                                            <option value="2" @if(isset($data)) {{ $data->efficiency == '2' ? 'selected' : ''  }} @endif> Intermediate</option>
                                                            <option value="3" @if(isset($data)) {{ $data->efficiency == '3' ? 'selected' : ''  }} @endif> Advanced</option>
                                                            <option value="4" @if(isset($data)) {{ $data->efficiency == '4' ? 'selected' : ''  }} @endif> Expert</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Technical Competency Ends ---->


                                    <!-- Behavioural Competency Ends ---->
                                    <div class="col-sm-6">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="panel-title" style="margin-left: 8px;">Behavioural / Organizational Competencies</h5>
                                            </div>
                                            <div class="card-body ">

                                                <div class="form-group row" id="border-none">
                                                    <label
                                                        class="col-sm-7 control-label">Integrity </label>
                                                    <div class="col-sm-5">
                                                        <select name="integrity" class="form-control m-b behave">
                                                            <option value="">Select</option>
                                                            <option value="1" @if(isset($data)) {{ $data->integrity == '1' ? 'selected' : ''  }} @endif> Beginner</option>
                                                            <option value="2" @if(isset($data)) {{ $data->integrity == '2' ? 'selected' : ''  }} @endif> Intermediate</option>
                                                            <option value="3" @if(isset($data)) {{ $data->integrity == '3' ? 'selected' : ''  }} @endif> Advanced</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row" id="border-none">
                                                    <label
                                                        class="col-sm-7 control-label">Professionalism </label>
                                                    <div class="col-sm-5">
                                                        <select name="professionalism" class="form-control m-b behave">
                                                             <option value="">Select</option>
                                                            <option value="1" @if(isset($data)) {{ $data->professionalism == '1' ? 'selected' : ''  }} @endif> Beginner</option>
                                                            <option value="2" @if(isset($data)) {{ $data->professionalism == '2' ? 'selected' : ''  }} @endif> Intermediate</option>
                                                            <option value="3" @if(isset($data)) {{ $data->professionalism == '3' ? 'selected' : ''  }} @endif> Advanced</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row" id="border-none">
                                                    <label
                                                        class="col-sm-7 control-label">Team Work</label>
                                                    <div class="col-sm-5">
                                                        <select name="team_work" class="form-control m-b behave">
                                                            <option value="">Select</option>
                                                            <option value="1" @if(isset($data)) {{ $data->team_work == '1' ? 'selected' : ''  }} @endif> Beginner</option>
                                                            <option value="2" @if(isset($data)) {{ $data->team_work == '2' ? 'selected' : ''  }} @endif> Intermediate</option>
                                                            <option value="3" @if(isset($data)) {{ $data->team_work == '3' ? 'selected' : ''  }} @endif> Advanced</option>
                                                            <option value="4" @if(isset($data)) {{ $data->team_work == '4' ? 'selected' : ''  }} @endif> Expert</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row" id="border-none">
                                                    <label
                                                        class="col-sm-7 control-label">Critical Thinking</label>
                                                    <div class="col-sm-5">
                                                        <select name="critical_thinking" class="form-control m-b behave">
                                                            <option value="">Select</option>
                                                            <option value="1" @if(isset($data)) {{ $data->critical_thinking == '1' ? 'selected' : ''  }} @endif> Beginner</option>
                                                            <option value="2" @if(isset($data)) {{ $data->critical_thinking == '2' ? 'selected' : ''  }} @endif> Intermediate</option>
                                                            <option value="3" @if(isset($data)) {{ $data->critical_thinking == '3' ? 'selected' : ''  }} @endif> Advanced</option>
                                                            <option value="4" @if(isset($data)) {{ $data->critical_thinking == '4' ? 'selected' : ''  }} @endif> Expert</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row" id="border-none">
                                                    <label
                                                        class="col-sm-7 control-label">Conflict Management</label>
                                                    <div class="col-sm-5">
                                                        <select name="conflict_management" class="form-control m-b behave">
                                                            <option value="">Select</option>
                                                            <option value="1" @if(isset($data)) {{ $data->conflict_management == '1' ? 'selected' : ''  }} @endif> Beginner</option>
                                                            <option value="2" @if(isset($data)) {{ $data->conflict_management == '2' ? 'selected' : ''  }} @endif> Intermediate</option>
                                                            <option value="3" @if(isset($data)) {{ $data->conflict_management == '3' ? 'selected' : ''  }} @endif> Advanced</option>
                                                            <option value="4" @if(isset($data)) {{ $data->conflict_management== '4' ? 'selected' : ''  }} @endif> Expert</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row" id="border-none">
                                                    <label
                                                        class="col-sm-7 control-label">Attendance</label>
                                                    <div class="col-sm-5">
                                                        <select name="attendance" class="form-control m-b behave">
                                                             <option value="">Select</option>
                                                            <option value="1" @if(isset($data)) {{ $data->attendance == '1' ? 'selected' : ''  }} @endif> Beginner</option>
                                                            <option value="2" @if(isset($data)) {{ $data->attendance == '2' ? 'selected' : ''  }} @endif> Intermediate</option>
                                                            <option value="3" @if(isset($data)) {{ $data->attendance == '3' ? 'selected' : ''  }} @endif> Advanced</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row" id="border-none">
                                                    <label
                                                        class="col-sm-7 control-label">Ability To Meet Deadline</label>
                                                    <div class="col-sm-5">
                                                        <select name="ability_to_meed_deadline" class="form-control m-b behave">
                                                            <option value="">Select</option>
                                                            <option value="1" @if(isset($data)) {{ $data->ability_to_meed_deadline == '1' ? 'selected' : ''  }} @endif> Beginner</option>
                                                            <option value="2" @if(isset($data)) {{ $data->ability_to_meed_deadline == '2' ? 'selected' : ''  }} @endif> Intermediate</option>
                                                            <option value="3" @if(isset($data)) {{ $data->ability_to_meed_deadline == '3' ? 'selected' : ''  }} @endif> Advanced</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Behavioural Competency Ends ---->

                                                
                                    <input type="hidden" name="total_technical" id="total_tech" value="{{ isset($data) ? $data->total_technical : '' }}">
                                     <input type="hidden" name="total_behaviour"  id="total_behave" value="{{ isset($data) ? $data->total_behaviour : '' }}">
                                     
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
             var check= $('.check').val();
                  
            $.ajax({
                url: '{{url("performance/checkDepartment")}}',
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
 $(document).on("change", function () {
     
      var b = 0;
        var t= 0;
     
      $(".tech").each(function () {
            t += +$(this).val();
             $("#total_tech").val(t);
        });
         $(".behave").each(function () {
               b += +$(this).val();
           $("#total_behave").val(b);
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