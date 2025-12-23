@extends('layouts.master')

@section('content')

<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Driver Details For {{$driver->driver_name}}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-2">
                                <ul class="nav nav-pills flex-column" id="myTab4" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active "  id="#tab1" 
                                        href="{{ route('driver.licence', $driver->id)}}"  aria-controls="home"
                                            aria-selected="true">Licence</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="#tab2" 
                                            href="{{ route('driver.performance', $driver->id)}}"  aria-controls="profile"
                                            aria-selected="false">Perfomance</a>
                                    </li>
                                     @can('view-cargo-menu')
                                     <li class="nav-item">
                                        <a class="nav-link " id="#tab3" 
                                            href="{{ route('driver.fuel', $driver->id)}}"  aria-controls="profile"
                                            aria-selected="false">Fuel Report</a>
                                    </li>

                               <li class="nav-item">
                                        <a class="nav-link" id="#tab4" 
                                            href="{{ route('driver.route', $driver->id)}}"  aria-controls="profile"
                                            aria-selected="false">Routes</a>
                                    </li>
                                   
                                     @endcan


                                </ul>
                            </div>
                            <div class="col-12 col-sm-12 col-md-10">
                                <div class="tab-content no-padding" id="myTab2Content">
                                    <div class="tab-pane fade @if($type =='licence' || $type == 'edit-licence') active show  @endif" id="tab1"
                                    role="tabpanel" aria-labelledby="tab1">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4>Licence</h4>
                                        </div>
                                        <div class="card-body">
                                            <ul class="nav nav-tabs" id="myTab2" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link @if($type =='licence') active show @endif" id="home-tab2"
                                                        data-toggle="tab" href="#home2" role="tab" aria-controls="home"
                                                        aria-selected="true">Licence List
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link @if($type =='edit-licence') active show @endif" id="profile-tab2"
                                                        data-toggle="tab" href="#profile2" role="tab" aria-controls="profile"
                                                        aria-selected="false"> New Licence</a>
                                                </li>
                                
                                            </ul>
                                            <div class="tab-content tab-bordered" id="myTab3Content">
                                                <div class="tab-pane fade @if($type =='licence') active show @endif" id="home2" role="tabpanel"
                                                    aria-labelledby="home-tab2">
                                                    <div class="table-responsive">
                                                     <table class="table datatable-basic table-striped">
                                                            <thead>
                                                                <tr role="row">
                                
                                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                                    rowspan="1" colspan="1"
                                                                    aria-label="Browser: activate to sort column ascending"
                                                                    style="width: 28.531px;">#</th>
                                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                                        colspan="1" aria-label="Engine version: activate to sort column ascending"
                                                                        style="width: 141.219px;">Class</th>
                                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                                        colspan="1" aria-label="Engine version: activate to sort column ascending"
                                                                        style="width: 141.219px;"> Issue Year</th>
                                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                                        colspan="1" aria-label="Engine version: activate to sort column ascending"
                                                                        style="width: 141.219px;"> Expire Year</th>
                                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                                        colspan="1" aria-label="Engine version: activate to sort column ascending"
                                                                        style="width: 141.219px;">Attachmentjjj</th>
                                                                    
                                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                                        colspan="1" aria-label="CSS grade: activate to sort column ascending"
                                                                        style="width: 98.1094px;">Actions</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @if(!@empty($licence))
                                                                @foreach ($licence as $row)
                                                                <tr class="gradeA even" role="row">
                                                                    <th>{{ $loop->iteration }}</th>
                                                                    <td>{{$row->class}}</td>
                                                                    <td>{{$row->year}}</td>
                                                                    <td>{{$row->expire}}</td>
                                                                    @if(!@empty($row->attachment))
                                                                    <td><a href="{{ route('ldownload',['download'=>'pdf','id'=>$row->id]) }}">Download</a></td>
                                                                    @else
                                                                    <td></td>                
                                                                    @endif
                                
                                
                                                                    <td>
                                                                         <div class="form-inline">
                                                                            <!-- Edit Button -->
                                                                            <a class="list-icons-item text-primary" href="{{ route('licence.edit', $row->id) }}">
                                                                                <i class="icon-pencil7"></i>
                                                                            </a>

                                                                              <!-- Delete Button Form -->
                                                                              {!! Form::open(['route' => ['licence.destroy', $row->id], 'method' => 'delete']) !!}
                                                                              {{ Form::button('<i class="icon-trash"></i>', [
                                                                              'type' => 'submit',
                                                                              'style' => 'border:none;background: none;',
                                                                              'class' => 'list-icons-item text-danger',
                                                                              'title' => 'Delete',
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
                                                <div class="tab-pane fade @if($type =='edit-licence') active show @endif" id="profile2"
                                                    role="tabpanel" aria-labelledby="profile-tab2">
                                
                                                    <div class="card">
                                                        <div class="card-header">
                                                            @if($type =='edit-licence')
                                                            <h5>Edit Licence</h5>
                                                            @else
                                                            <h5>New Licence</h5>
                                                            @endif
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-sm-12 ">
                                                                    @if($type =='edit-licence')
                                                                    {{ Form::model($id, array('route' => array('licence.update', $id), 'method' => 'PUT',"enctype"=>"multipart/form-data")) }}
                                                                    @else
                                                                    {{ Form::open(['route' => 'licence.store',"enctype"=>"multipart/form-data"]) }}
                                                                    @method('POST')
                                                                    @endif
                                
                                                                    <div class="form-row">
                                                                        <div class="form-group col-md-6">
                                                                            
                                                                            <input type="hidden" name="driver_id" class="form-control" id="type"
                                                                                value="{{$driver->id}}" placeholder="">

                                                                            <label for="inputEmail4">Class</label>
                                                                             <input type="text" name="class"
                                                                         value="{{ isset($data) ? $data->class : ''}}"
                                                            class="form-control" required>
                                                                        </div>
                                                                        <div class="form-group col-md-6">
                                                           
                                                                            <label for="inputEmail4">Licence Attachment</label>
                                                                            <input type="file" name="attachment" class="form-control"
                                                                                id="attachment"
                                                                                value=" {{ !empty($data) ? $data->attachment : ''}}"
                                                                                placeholder="">
                                                                        </div>
                                                                        </div>
                                
                                
                                                                    
                                                                    <div class="form-row">
                                                                        <div class="form-group col-md-6">
                                
                                                                            <label for="inputEmail4">Issue Year</label>
                                                                            <input type="text" name="year" class="form-control" id="datepicker" 
                                                                                value=" {{ !empty($data) ? $data->year : ''}}"  
                                                                                required>
                                                                        </div>
                                                                        
                                                                        <div class="form-group col-md-6 col-lg-6">
                                                                            <label for="date">Expire Year</label>
                                                                            <input type="text" name="expire" class="form-control" id="datepicker2"
                                                                                value="{{ !empty($data) ? $data->expire : ''}}" 
                                                                                required>
                                
                                                                        </div>
                                         
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <div class="col-lg-offset-2 col-lg-12">
                                                                            @if($type =='edit-licence')
                                                                            <button class="btn btn-sm btn-primary float-right m-t-n-xs"
                                                                                data-toggle="modal" data-target="#myModal" type="submit">Update</button>
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
            "columnDefs": [
                {"targets": [0]}
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
<script src="{{ asset('assets2/js/bootstrap-datepicker.min.js') }}"></script>

<script type="text/javascript">
 $(document).ready(function(){
  $("#datepicker,#datepicker2").datepicker({
     format: "yyyy",
     viewMode: "years", 
     minViewMode: "years",
     autoclose:true
  });   
})

 </script>
@endsection