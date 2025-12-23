@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Class Account</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link @if(empty($id)) active show @endif" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Class Account
                                    List</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if(!empty($id)) active show @endif" id="profile-tab2"
                                    data-toggle="tab" href="#profile2" role="tab" aria-controls="profile"
                                    aria-selected="false">New Class Account</a>
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
                                                    style="width: 120.484px;">Class ID</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 186.484px;">Name</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 101.219px;">Class Type</th>
                                                <th class="always-visible" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 120.1094px;">Actions</th>
                                            </tr>
                                        </thead>
                                         <tbody>
                                            @if(!@empty($class))
                                            @foreach ($class as $row)
                                             <?php
                                    $bfr=App\Models\GroupAccount::where('class',$row->id)->where('disabled','0')->where('added_by',auth()->user()->added_by)->count();
                                    ?>
                                            <tr class="gradeA even" role="row">
                                                <th>{{ $loop->iteration }}</th>
                                                <td>{{$row->class_id}}</td>
                                                <td>{{$row->class_name}}</td>
                                                <td>{{$row->class_type}}</td>                                           
                                              
                                              

                                                <td>
                                                 @if($row->edited == '1')
                                                 <div class="form-inline">
                                                
                                                    <a class="list-icons-item text-primary"
                                                        href="{{ route("class_account.edit", $row->id)}}">
                                                      <i class="icon-pencil7"></i>
                                                    </a>&nbsp

                                           @if($bfr == '0')
                                              {!! Form::open(['route' => ['class_account.destroy',$row->id], 'method' => 'delete']) !!}
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
                                        <h5>Create Class Account</h5>
                                        @else
                                        <h5>Edit Class Account</h5>
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">
                                                @if(isset($id))
                                                {{ Form::model($id, array('route' => array('class_account.update', $id), 'method' => 'PUT')) }}
                                                @else
                                                {{ Form::open(['route' => 'class_account.store']) }}
                                                @method('POST')
                                                @endif



                                            

                                               <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Name</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" name="class_name" required
                                                            placeholder=""
                                                            value="{{ isset($data) ? $data->class_name : ''}}"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                               
                                                <div class="form-group row"><label
                                                        class="col-lg-2 col-form-label">Class Type</label>

                                                    <div class="col-lg-8">
                                                    <select class="form-control m-b" name="class_type" required>
                                                 <option value="">Select Class Type</option>
                                                       <option value="Assets" @if(isset($data))@if($data->class_type == 'Assets') selected @endif @endif >Assets</option>
                                                    <option value="Liability" @if(isset($data))@if($data->class_type == 'Liability') selected @endif @endif>Liability</option>
                                                    <option value="Equity" @if(isset($data))@if($data->class_type == 'Equity') selected @endif @endif >Equity</option>
                                                      <option value="Expense" @if(isset($data))@if($data->class_type == 'Expense') selected @endif @endif >Expense</option>
                                                        <option value="Income" @if(isset($data))@if($data->class_type == 'Income') selected @endif @endif>Income</option>
                                                        </select>
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
          {extend: 'copyHtml5',title: 'CLASS ACCOUNT ',  exportOptions:{columns: ':visible :not(.always-visible)'},footer: true},
           {extend: 'excelHtml5',title: 'CLASS ACCOUNT' , exportOptions:{columns: ':visible :not(.always-visible)'}, footer: true},
           {extend: 'csvHtml5',title: 'CLASS ACCOUNT' ,  exportOptions:{columns: ':visible :not(.always-visible)'},footer: true},
            {extend: 'pdfHtml5',title: 'CLASS ACCOUNT',  exportOptions:{columns: ':visible :not(.always-visible)'},footer: true,customize: function(doc) {
doc.content[1].table.widths = [ '10%', '10%', '50%','30%'];
}
},
            {extend: 'print',title: 'CLASS ACCOUNT' , exportOptions:{columns: ':visible :not(.always-visible)'}, footer: true}

                ],
        }
      );
     
    </script>


@endsection