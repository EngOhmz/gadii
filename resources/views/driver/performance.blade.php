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
                                        <a class="nav-link" href="{{ route('driver.licence', $driver->id)}}" aria-controls="home"
                                            aria-selected="true">Licence</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active "
                                        id="#tab1"  href="{{ route('driver.performance', $driver->id)}}" 
                                        href="#tab1"  aria-controls="profile"
                                            aria-selected="false">Perfomance</a>
                                    </li>
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
                                   
                                     


                                </ul>
                            </div>
                            <div class="col-12 col-sm-12 col-md-10">
                                <div class="tab-content no-padding" id="myTab2Content">
                                    <div class="tab-pane fade @if($type =='performance' || $type == 'edit-performance') active show  @endif" id="tab1"
                                    role="tabpanel" aria-labelledby="tab1">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4>Performance</h4>
                                        </div>
                                        <div class="card-body">
                                            <ul class="nav nav-tabs" id="myTab2" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link @if($type =='performance') active show @endif" id="home-tab2"
                                                        data-toggle="tab" href="#home2" role="tab" aria-controls="home"
                                                        aria-selected="true">Performance List
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link @if($type =='edit-performance') active show @endif" id="profile-tab2"
                                                        data-toggle="tab" href="#profile2" role="tab" aria-controls="profile"
                                                        aria-selected="false"> New Performance</a>
                                                </li>
                                
                                            </ul>
                                            <div class="tab-content tab-bordered" id="myTab3Content">
                                                <div class="tab-pane fade @if($type =='performance') active show @endif" id="home2" role="tabpanel"
                                                    aria-labelledby="home-tab2">
                                                    <div class="table-responsive">
                                                        <table class="table table-striped" id="table-1">
                                                            <thead>
                                                                <tr role="row">
                                
                                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                                    rowspan="1" colspan="1"
                                                                    aria-label="Browser: activate to sort column ascending"
                                                                    style="width: 208.531px;">#</th>
                                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                                        colspan="1" aria-label="Engine version: activate to sort column ascending"
                                                                        style="width: 141.219px;">Report Issue</th>
                                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                                        colspan="1" aria-label="Engine version: activate to sort column ascending"
                                                                        style="width: 141.219px;"> Date</th>
                                                                    
                                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                                        colspan="1" aria-label="Engine version: activate to sort column ascending"
                                                                        style="width: 141.219px;">Attachment</th>
                                                                    
                                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                                        colspan="1" aria-label="CSS grade: activate to sort column ascending"
                                                                        style="width: 98.1094px;">Actions</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @if(!@empty($performance))
                                                                @foreach ($performance as $row)
                                                                <tr class="gradeA even" role="row">
                                                                    <th>{{ $loop->iteration }}</th>
               
                                                                    <td>{{$row->issue}}</td>
                                                                    <td>{{Carbon\Carbon::parse($row->date)->format('M d, Y')}}</td>
                                                                    @if(!@empty($row->attachment))
                                                                    <td><a href="{{ route('pdownload',['download'=>'pdf','id'=>$row->id]) }}">Download</a></td>
                                                                    @else
                                                                    <td></td>                
                                                                    @endif
                                
                                                                    <td>
                                                                        
                                                                        <a class="btn btn-xs btn-outline-primary text-uppercase px-2 rounded"
                                                                        href="{{ route("performance.edit", $row->id)}}">
                                                                        <i class="fa fa-edit"></i>
                                                                    </a>

                                                                    {!! Form::open(['route' => ['performance.destroy',$row->id],
                                                    'method' => 'delete']) !!}
                                                    {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-xs btn-outline-danger text-uppercase px-2 rounded demo4', 'title' => 'Delete', 'onclick' => "return confirm('Are you sure?')"]) }}
                                                    {{ Form::close() }}

                                
                                
                                                                    </td>
                                                                </tr>
                                                                @endforeach
                                
                                                                @endif
                                
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade @if($type =='edit-performance') active show @endif" id="profile2"
                                                    role="tabpanel" aria-labelledby="profile-tab2">
                                
                                                    <div class="card">
                                                        <div class="card-header">
                                                            @if($type =='edit-performance')
                                                            <h5>Edit Performance</h5>
                                                            @else
                                                            <h5>New Performance</h5>
                                                            @endif
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-sm-12 ">
                                                                    @if($type =='edit-performance')
                                                                    {{ Form::model($id, array('route' => array('performance.update', $id), 'method' => 'PUT',"enctype"=>"multipart/form-data")) }}
                                                                    @else
                                                                    {{ Form::open(['route' => 'performance.store',"enctype"=>"multipart/form-data"]) }}
                                                                    @method('POST')
                                                                    @endif
                                
                                                                    <div class="form-row">
                                                                        <div class="form-group col-md-6">
                                                                            
                                                                            <input type="hidden" name="driver_id" class="form-control" id="type"
                                                                                value="{{$driver->id}}" placeholder="">

                                                                            <label for="inputEmail4">Report Issue</label>
                                                                             <input type="text" name="issue"
                                                                         value="{{ isset($data) ? $data->issue : ''}}"
                                                            class="form-control" required>
                                                                        </div>
                                                                        <div class="form-group col-md-6">
                                                           
                                                                            <label for="inputEmail4">Attachment of displine letter</label>
                                                                            <input type="file" name="attachment" class="form-control"
                                                                                id="attachment"
                                                                                value=" {{ !empty($data) ? $data->attachment : ''}}"
                                                                                placeholder="">
                                                                        </div>
                                                                        </div>
                                
                                
                                                                    
                                                                    <div class="form-row">
                                                                        <div class="form-group col-md-6">
                                
                                                                            <label for="inputEmail4">Date</label>
                                                                            <input type="date" name="date" class="form-control"  
                                                                                value="{{ !empty($data) ? $data->date: ''}}"  
                                                                                required>
                                                                        </div>
                                                                        
                                                                        <div class="form-group col-md-6">
                                
                                                                            <label for="inputEmail4"> Reason</label>
                                                                            <textarea name="reason" class="form-control" id="reason" required>
                                                                                {{ !empty($data) ? $data->reason: ''}}</textarea>
                                                                        </div>
                                                                        
                                         
                                                                    </div>

                                                                    <div class="form-row">
                                                                        <div class="form-group col-md-6">
                                                                            

                                                                            <label for="inputEmail4">Driver Explanation</label>
                                                                            <textarea name="explanation" class="form-control" id="explanation" required>
                                                                                {{ !empty($data) ? $data->explanation: ''}}</textarea>
                                                                        </div>
                                                                        <div class="form-group col-md-6">
                                                           
                                                                            <label for="inputEmail4">Effect to the Company</label>
                                                                            <textarea name="effect" class="form-control" id="reason" required>
                                                                                {{ !empty($data) ? $data->effect: ''}}</textarea>
                                                                        </div>
                                                                        </div>

                                                                    <div class="form-group row">
                                                                        <div class="col-lg-offset-2 col-lg-12">
                                                                            @if($type =='edit-performance')
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/js/bootstrap-datepicker.min.js"></script>
<script>
    function myFunction() {
       // alert('hellow')
  //var element = document.getElementById("#tab2");
  //element.classList.add("active");
}
</script>
<script type="text/javascript">
 $(document).ready(function(){
  $("#datepicker,#datepicker2").datepicker({
     format: "dd/mm/yyyy",
     viewMode: "days", 
     minViewMode: "days",
     autoclose:true
  });   
})

 </script>
@endsection