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
                                        <a class="nav-link "  id="#tab1" 
                                        href="{{ route('truck.insurance', $truck->id)}}"  aria-controls="home"
                                            aria-selected="true">Insurance</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="#tab2" 
                                            href="{{ route('truck.sticker', $truck->id)}}"  aria-controls="profile"
                                            aria-selected="false">LATRA Sticker</a>
                                    </li>
                               <li class="nav-item">
                                        <a class="nav-link  active" id="#tab3" 
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
                                    <div class="tab-pane fade @if($type =='fuel') active show  @endif" id="tab1"
                                    role="tabpanel" aria-labelledby="tab1">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4></h4>
                                        </div>
                                        <div class="card-body">
                                           
                                            <div class="tab-content tab-bordered" id="myTab3Content">


                                  <div class="panel-heading">
            <h5 class="panel-title">
               Fuel Report
              @if(!empty($start_date))
                    for the period: <b>{{$start_date}} to  {{$end_date}}</b>
                @endif
            </h5>
        </div>

<br>
        <div class="panel-body hidden-print">
            {!! Form::open(array('url' => Request::url(), 'method' => 'post','class'=>'form-horizontal', 'name' => 'form')) !!}
            <div class="row">

                <div class="col-md-4">
                    <label class="">Start Date</label>
                    {!! Form::date('start_date',$start_date, array('class' => 'form-control date-picker', 'placeholder'=>"First Date",'required'=>'required')) !!}
                </div>
                <div class="col-md-4">
                    <label class="">End Date</label>
                   {!! Form::date('end_date',$end_date, array('class' => 'form-control date-picker', 'placeholder'=>"Third Date",'required'=>'required')) !!}
                </div>

   <div class="col-md-4">
                      <br><button type="submit" class="btn btn-success">Search</button>
                        <a href="{{Request::url()}}"class="btn btn-danger">Reset</a>

                </div>                  
                </div>
           
            {!! Form::close() !!}

        </div>

        <!-- /.panel-body -->

   <br>
                                                <div class="tab-pane fade @if($type =='fuel') active show @endif" id="home2" role="tabpanel"
                                                    aria-labelledby="home-tab2">
                                                    <div class="table-responsive">
                                                        <table class="table table-striped" id="table-1">
                                                            <thead>
                                                                <tr>
                                
                                                                    <th>#</th>
                        <th>Date</th>
                 <th>Route Name</th>
                        <th>Assigned Vol</th>
                        <th>Ajdusted Vol</th>
                        <th>Adjusted Vol Approved By</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @if(!@empty($fuel))
                                                                @foreach ($fuel as $row)
                                                                <tr class="gradeA even" role="row">
                                                                    <th>{{ $loop->iteration }}</th>
                                                                    <td>{{Carbon\Carbon::parse($row->created_at)->format('d/m/Y')}}</td>
                                                                    <td>From {{$row->route->from}} to {{$row->route->to}}</td>
                                                                   <td>{{number_format($row->fuel_used,2)}} Litres</td>                                                          
                                                                    <td>{{number_format($row->fuel_adjustment,2)}} Litres</td>
                                                                  @if(!@empty($row->approved_by))
                                                                    <td>
                                                                  @php
                                                              $approve=App\Models\User::find($row->approved_by);
                                                              @endphp

                                                {{$approve->name}}</td>
                                                              @else
                                                             <td></td>
                                                   @endif
                                
                                                                   
                                                                </tr>
                                                                @endforeach

                                                           
                                                                @endif
                                
                                                            </tbody>
                                                        </table>
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