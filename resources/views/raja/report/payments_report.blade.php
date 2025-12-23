@extends('layouts.master')


@section('content')

<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Payment Report</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link @if(empty($id)) active show @endif" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Payment Report
                                    List</a>
                            </li>
                       

                        </ul>
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">

<br>


        <div class="panel-heading">
            <h6 class="panel-title">
    
                @if(!empty($class))
                {{ strtoupper($class) }}  Payment Report for the Year {{$year}}</b>
                @endif
            </h6>
        </div>

<br>
        <div class="panel-body hidden-print">
            {!! Form::open(array('url' => Request::url(), 'method' => 'post','class'=>'form-horizontal', 'name' => 'form')) !!}
            <div class="row">

                <div class="col-md-4">
                  <label class="">Class</label>
                    {!! Form::select('class',$schools,$class, array('class' => 'm-b class','id'=>'class','placeholder'=>'Select','style'=>'width:100%','required'=>'required')) !!}

                </div>
               

                <div class="col-md-4">
                    <label class="">Year</label>
                    <input type="text" name="year" class="form-control" id="datepicker"  required  value="{{ isset($year) ? $year : date('Y')}}">                
                </div>

 <div class="col-md-12">
                      <br><button type="submit" class="btn btn-success">Search</button>
                        <a href="{{Request::url()}}"class="btn btn-danger">Reset</a>

                        

                </div>  

  
           
            {!! Form::close() !!}

        </div>

        <!-- /.panel-body -->

   <br> <br>
@if(!empty($class))
        <div class="panel panel-white">
            <div class="panel-body ">
                <div class="table-responsive">

 @php $tt =0; @endphp
                                    <table class="table datatable-button-html5-basic" id="itemsDatatable">
                        <thead>
                        <tr>
                           
                            <th >#</th>
                                            <th>Student</th> 
                                            <th>Reference</th> 
                                            <th>Amount</th> 
                                            <th>Payment Account</th> 
                                            <th>Payment Date</th>   
                                            <th class="always-visible">Action</th>
                                                
                      
                        </tr>
                        </thead>
                        <tbody>


                        @foreach($data as $row)
                        
                          @php
                             $paid=App\Models\School\SchoolPayment::where('added_by',auth()->user()->added_by)->where('type','!=','Discount Fees')->where('multiple',$row->multiple)->sum('paid');
                                        
                                        @endphp
                        <tr>
                                           
                                           <td>{{ $loop->iteration }}</td>
                                           <td>@if(!empty($row->student_id)){{$row->student->student_name}}@endif</td>
                                            <td>{{$row->reference}}</td>
                                             <td>{{number_format($paid,2)}} </td>     
                                             <td>@if(!empty($row->bank_id)){{$row->chart->account_name}}@endif</td>
                                            <td>{{Carbon\Carbon::parse($row->date)->format('M d, Y')}}</td>
                                            <td><a  href="{{ route('payments_receipt',['download'=>'pdf','id'=>$row->id]) }}"  title="" > Download Receipt </a> </td>
                                        </tr>
                                        
                                         @php $tt +=$paid; @endphp
                                        @endforeach
                                       
                                    </tbody>
                                    
                                    
                                    <tfoot>
                                       
                                       
                                        <tr>
                                           
                                           <th></th>
                                           <td></td>
                                            <td></td>
                                             <td>{{number_format($tt,2)}} </td>     
                                             <td></td>
                                            <td></td>
                                            <td> </td>
                                        </tr>
                                    </tfoot>
                                   
                    </table>






                  
                </div>
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
 <link rel="stylesheet" href="{{ asset('assets/datatables/css/jquery.dataTables.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/datatables/css/buttons.dataTables.min.css') }}">

    <script src="{{ asset('assets/datatables/js/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/datatables/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/datatables/js/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/datatables/js/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/datatables/js/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/datatables/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/datatables/js/buttons.print.min.js') }}"></script>
    
    
    
</script>
    
    
    

    <script>
        $(function() {
          
            
            $('#itemsDatatable').DataTable({
                processing: true,
                serverSide: false,
                searching: true,
                "dom": 'lBfrtip',


                buttons: [{
                        extend: 'copyHtml5',
                        title: '{{ strtoupper($class) }} PAYMENT REPORT FOR THE YEAR {{$year}}',
                        exportOptions: {
                            columns: ':visible :not(.always-visible)'
                        },
                      
                        footer: true
                    },
                    {
                        extend: 'excelHtml5',
                        title: '{{ strtoupper($class) }} PAYMENT REPORT FOR THE YEAR {{$year}}',
                        exportOptions: {
                            columns: ':visible :not(.always-visible)'
                        },
                       
                        footer: true
                    },
                    {
                        extend: 'csvHtml5',
                        title: '{{ strtoupper($class) }} PAYMENT REPORT FOR THE YEAR {{$year}}',
                        exportOptions: {
                            columns: ':visible :not(.always-visible)'
                        },
                        footer: true
                    },
                    {
                        extend: 'pdfHtml5',
                        title: '{{ strtoupper($class) }} PAYMENT REPORT FOR THE YEAR {{$year}}',
                        exportOptions: {
                            columns: ':visible :not(.always-visible)',
                        },
                        footer: true
                    },
                    {
                        extend: 'print',
                        title: '{{ strtoupper($class) }} PAYMENT REPORT FOR THE YEAR {{$year}}',
                        exportOptions: {
                            columns: ':visible :not(.always-visible)'
                        },
                        footer: true
                    }

                ],

                
     
            })
        });


    </script>

    
    

<script src="{{url('assets/js/bootstrap-datepicker.min.js')}}"></script>
<script type="text/javascript">
 $(document).ready(function(){
  $("#datepicker").datepicker({
     format: "yyyy",
     viewMode: "years", 
     minViewMode: "years",
     autoclose:true
  });   
})

 </script>


@endsection