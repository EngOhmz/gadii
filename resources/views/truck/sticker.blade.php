@extends('layouts.master')

@section('content')

<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                         <h4>Truck Details For {{$truck->truck_name}} - {{$truck->reg_no}}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-2">
                                <ul class="nav nav-pills flex-column" id="myTab4" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link"  id="#tab1" 
                                        href="{{ route('truck.insurance', $truck->id)}}"  aria-controls="home"
                                            aria-selected="true">Insurance</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active" id="#tab2" 
                                            href="{{ route('truck.sticker', $truck->id)}}"  aria-controls="profile"
                                            aria-selected="false">LATRA Sticker</a>
                                    </li>
                                     <li class="nav-item">
                                        <a class="nav-link" id="#tab3" 
                                            href="{{ route('truck.fuel', $truck->id)}}"  aria-controls="profile"
                                            aria-selected="false">Fuel Report</a>
                                    </li>

                               <li class="nav-item">
                                        <a class="nav-link" id="#tab4" 
                                            href="{{ route('truck.route', $truck->id)}}"  aria-controls="profile"
                                            aria-selected="false">Routes</a>
                                    </li>
                                     


                                </ul>
                            </div>
                            <div class="col-12 col-sm-12 col-md-10">
                                <div class="tab-content no-padding" id="myTab2Content">
                                    <div class="tab-pane fade @if($type =='sticker' || $type == 'edit-sticker') active show  @endif" id="tab1"
                                    role="tabpanel" aria-labelledby="tab1">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4>LATRA Sticker</h4>
                                        </div>
                                        <div class="card-body">
                                            <ul class="nav nav-tabs" id="myTab2" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link @if($type =='sticker') active show @endif" id="home-tab2"
                                                        data-toggle="tab" href="#home2" role="tab" aria-controls="home"
                                                        aria-selected="true">Sticker List
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link @if($type =='edit-sticker') active show @endif" id="profile-tab2"
                                                        data-toggle="tab" href="#profile2" role="tab" aria-controls="profile"
                                                        aria-selected="false"> New Sticker</a>
                                                </li>
                                
                                            </ul>
                                            <div class="tab-content tab-bordered" id="myTab3Content">
                                                <div class="tab-pane fade @if($type =='sticker') active show @endif" id="home2" role="tabpanel"
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
                                                                        style="width: 141.219px;">Issue Date</th>
                                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                                        colspan="1" aria-label="Engine version: activate to sort column ascending"
                                                                        style="width: 141.219px;"> Expire Date</th>
                                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                                        colspan="1" aria-label="Engine version: activate to sort column ascending"
                                                                        style="width: 141.219px;">Issue Office</th>
                                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                                        colspan="1" aria-label="Engine version: activate to sort column ascending"
                                                                        style="width: 141.219px;"> Issue Officer</th>
                                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                                        colspan="1" aria-label="Engine version: activate to sort column ascending"
                                                                        style="width: 141.219px;">Amount</th>
                                                                    
                                                                    
                                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                                        colspan="1" aria-label="CSS grade: activate to sort column ascending"
                                                                        style="width: 98.1094px;">Actions</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @if(!@empty($sticker))
                                                                @foreach ($sticker as $row)
                                                                <tr class="gradeA even" role="row">
                                                                    <th>{{ $loop->iteration }}</th>
                                                                    <td>{{Carbon\Carbon::parse($row->issue_date)->format('M d, Y')}}</td>
                                                                    <td>{{Carbon\Carbon::parse($row->expire_date)->format('M d, Y')}}</td>
                                                                    <td>{{$row->office}}</td>
                                                                    <td>{{$row->officer}}</td>
                                                                    
                                                                    <td>{{number_format($row->value,2)}}</td>
                                                                   
                                
                                
                                                                    <td>
                                                                        
                                                                        <a class="btn btn-xs btn-outline-primary text-uppercase px-2 rounded"
                                                                        href="{{ route("sticker.edit", $row->id)}}">
                                                                        <i class="fa fa-edit"></i>
                                                                    </a>
                                                                    
                                
                                                                    {!! Form::open(['route' => ['sticker.destroy',$row->id],
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
                                                <div class="tab-pane fade @if($type =='edit-sticker') active show @endif" id="profile2"
                                                    role="tabpanel" aria-labelledby="profile-tab2">
                                
                                                    <div class="card">
                                                        <div class="card-header">
                                                            @if($type =='edit-sticker')
                                                            <h5>Edit Sticker</h5>
                                                            @else
                                                            <h5>New Sticker</h5>
                                                            @endif
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-sm-12 ">
                                                                    @if($type =='edit-sticker')
                                                                    {{ Form::model($id, array('route' => array('sticker.update', $id), 'method' => 'PUT',"enctype"=>"multipart/form-data")) }}
                                                                    @else
                                                                    {{ Form::open(['route' => 'sticker.store',"enctype"=>"multipart/form-data"]) }}
                                                                    @method('POST')
                                                                    @endif
                                
                                                                    
                                                                        <div class="form-row">
                                                                            <div class="form-group col-md-6">
                                    
                                                                                <label for="inputEmail4">Issue Date</label>
                                                                                <input type="date" name="issue_date" class="form-control" 
                                                                                    value="{{ !empty($data) ? $data->issue_date : ''}}"  
                                                                                    required>
                                                                            </div>
                                                                            
                                                                            <div class="form-group col-md-6 col-lg-6">
                                                                                <label for="date">Expire Date</label>
                                                                                <input type="date" name="expire_date" class="form-control"
                                                                                    value="{{ !empty($data) ? $data->expire_date : ''}}" 
                                                                                    required>
                                    
                                                                            </div>
                                             
                                                                        </div>

                                                                        <div class="form-row">
                                                                        <div class="form-group col-md-6">
                                                                            
                                                                            <input type="hidden" name="truck_id" class="form-control" id="type"
                                                                                value="{{$truck->id}}" placeholder="">

                                                                            <label for="inputEmail4">Issue Office</label>
                                                                             <input type="text" name="office"
                                                                         value="{{ isset($data) ? $data->office : ''}}"
                                                            class="form-control" required>
                                                                        </div>


                                                                        <div class="form-group col-md-6">
                                                           
                                                                             <label for="inputEmail4">Issue Officer</label>
                                                                             <input type="text" name="officer"
                                                                         value="{{ isset($data) ? $data->officer : ''}}"
                                                            class="form-control" required>
                                                                        </div>
                                                                        </div>
                                
                                                                      
                                                                        <div class="form-row">
                                                                            <div class="form-group col-md-6">
                                                               
                                                                                 <label for="inputEmail4">Amount</label>
                                                                                 <input type="number" name="value"
                                                                             value="{{ isset($data) ? $data->value : ''}}"
                                                                class="form-control" required>
                                                                            </div>
                                                                            </div>
                                                                    
                                                                 
                                                                    <div class="form-group row">
                                                                        <div class="col-lg-offset-2 col-lg-12">
                                                                            @if($type =='edit-sticker')
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
     format: "yyyy",
     viewMode: "years", 
     minViewMode: "years",
     autoclose:true
  });   
})

 </script>
@endsection