@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Check Availability</h4>
                    </div>
                    <div class="card-body">
                        
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">


         <h6 class="panel-title">
                
                @if(!empty($start_date))
                   For the period: <b>{{Carbon\Carbon::parse($start_date)->format('d/m/Y')}}  to {{Carbon\Carbon::parse($end_date)->format('d/m/Y')}}</b>
                @endif
            </h6>

<br>
        <div class="panel-body hidden-print">
            {!! Form::open(array('url' => Request::url(), 'method' => 'post','class'=>'form-horizontal', 'name' => 'form')) !!}
            <div class="row">

               <div class="col-md-4">
                    <label class="">Check In Date</label>
                   <input  name="start_date" id="start_date" type="date" class="form-control date-picker" onkeydown="return false" required value="<?php
                if (!empty($start_date)) {
                    echo $start_date;
                } else {
                     echo date('Y-m-d');
                }
                ?>">

                </div>
                <div class="col-md-4">
                    <label class="">Check Out Date</label>
                     <input  name="end_date" id="end_date" type="date" class="form-control date-picker" onkeydown="return false" required value="<?php
                if (!empty($end_date)) {
                    echo $end_date;
                } else {
                     echo date('Y-m-d', strtotime('+1 days'));
                }
                ?>">
                </div>

                
               

                <div class="col-md-4">
                    <label class="">Property</label> 
                   
                    <select name="location_id" class="form-control m-b" id="location_id" required>
                        <option value="">Select Property</option>
                        @if(!empty($location))
                       
                        @foreach($location as $br)
                        <option value="{{$br->id}}" @if(isset($location_id)){{  $location_id == $br->id  ? 'selected' : ''}} @endif>{{$br->name}}</option>
                        @endforeach
                      
                        @endif
                    </select>
                    
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

@if(!empty($start_date))
<div class="panel panel-white">
            <div class="panel-body ">
               



<!-- Horizontal cards view -->
{!! Form::open(array('route' => 'booking.save_availability','method'=>'POST', 'class' => 'book-example' , 'name' => 'book-example')) !!}
					<div class="pt-2 mb-3">
					<span style="font-weight:bold;font-size:15px;">{{$count}} rooms found</span>
						
						  @if($count > 0) <button class="btn btn-sm btn-primary float-right m-t-n-xs"  type="submit" id="save">Book</button>@endif
						<hr>
					</div>

                     
                    
                      
					<div class="row">
					  @if(!empty($data))
					  
			<input type="hidden" name="start_date" class="form-control daterange" value="{{$start_date}}"/>
			<input type="hidden" name="end_date" class="form-control daterange" value="{{$end_date}}"/>
				<input type="hidden" name="location" class="form-control" value="{{$location_id}}"/>
				  
					  @foreach($data as $row)
						<div class="col-lg-4">
						
						<div class="card card-body">
								<div class="d-flex">
								
                                    @php $type=App\Models\Hotel\RoomType::find($row->room_type); @endphp
									<div class="flex-fill">
										<h6 class="mb-0">Type : {{$type->name}}</h6>
										<h6 class="mb-0">Room Name : {{$row->name}}</h6>
										<h6 class="mb-0">Price : {{number_format($row->price)}}</h6><br>
													
										<span class="">Description : {{$row->description}}</span><br>
										<span class="">Service : {{$row->service}}</span>
									</div>
									
					<div class="flex-shrink-0 ms-sm-3 mt-2 mt-sm-0">
							 <input name="trans_id[]" type="checkbox"  class="checks" value="{{$row->id}}">
							</div>
									
								
									

								
							</div>
						</div>
						</div>
						@endforeach
						
						@else
						
							<div class="col-lg-12">
						
						<div class="card card-body">
								<div class="d-flex">
								

								<br>
										<h5 align="center" class="mb-0">NO DATA FOUND</h5>
									
									
									
					
									
								
									

								
							</div>
						</div>
						</div>
						
						
					

@endif
	

				
					</div>
					<!-- /horizontal cards view -->
                  	 {!! Form::close() !!}
                  
                </div>
            
            <!-- /.panel-body -->
             </div>
                 
@endif
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
    
    $(document).ready(function() { //DISABLED PAST DATES IN APPOINTMENT DATE
  var dateToday = new Date();
  var month = dateToday.getMonth() + 1;
  var day = dateToday.getDate();
  var year = dateToday.getFullYear();

  if (month < 10)
    month = '0' + month.toString();
  if (day < 10)
    day = '0' + day.toString();

  var maxDate = year + '-' + month + '-' + day;

  $('#start_date').attr('min', maxDate);
   $('#end_date').attr('min', maxDate);
});
    </script>


@endsection