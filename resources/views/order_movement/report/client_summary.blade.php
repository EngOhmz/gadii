@extends('layouts.master')


@section('content')


    
    
    
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Client Summary</h4>
                    </div>
                    <div class="card-body">
                       
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">

<br>


        <div class="panel-heading">
            <h6 class="panel-title">
            
                @if(!empty($start_date))
                   For the period: <b>{{Carbon\Carbon::parse($start_date)->format('d/m/Y')}} to {{Carbon\Carbon::parse($end_date)->format('d/m/Y')}} </b>
                @endif
            </h6>
        </div>

<br>
        <div class="panel-body hidden-print">
            {!! Form::open(array('url' => Request::url(), 'method' => 'post','class'=>'form-horizontal', 'name' => 'form')) !!}
            <div class="row">

                <div class="col-md-4">
                    <label class="">Start Date</label>
                   <input  name="start_date" type="date" class="form-control date-picker" required value="<?php
                if (!empty($start_date)) {
                    echo $start_date;
                } else {
                    echo date('Y-m-d', strtotime('first day of january this year'));
                }
                ?>">

                </div>
                <div class="col-md-4">
                    <label class="">End Date</label>
                     <input  name="end_date" type="date" class="form-control date-picker" required value="<?php
                if (!empty($end_date)) {
                    echo $end_date;
                } else {
                    echo date('Y-m-d');
                }
                ?>">
                </div>


   <div class="col-md-12">
                      <br><button type="submit" class="btn btn-success">Search</button>
                        <a href="{{Request::url()}}"class="btn btn-danger">Reset</a>
                      
                      
                </div>                  
                </div>
           
            {!! Form::close() !!}

        </div>

        <!-- /.panel-body -->

   <br> <br>

        <div class="panel panel-white">
            <div class="panel-body ">
                <div class="table-responsive">

                    <table class="table datatable-basic" id="example">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                       <th> No of Trips</th>
                       
                        </tr>
                        </thead>
                        <tbody>
                          <?php
                        $tt = 0;
                        $ti = 0;
                          $te = 0;
                         $ts = 0;
                        $tm = 0;
                        $tr= 0;
                           $tb= 0;
?>
                        @foreach($data as $key)
                          <?php
                      

                       if(!empty($start_date)){
                      $trips = \App\Models\CargoLoading::where('owner_id',$key->id)->whereBetween('collection_date',[$start_date,$end_date])->count('id');
                           
                       }
                        else{
                           
                         $trips = \App\Models\CargoLoading::where('owner_id',$key->id)->count('id');
                          
                      }

                    $tt += $trips;
                       
 
                        ?>
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                 <td>{{ $key->name}} 
                                         
                                    <td>{{ number_format($trips,2)}} </td>
                                    
                                
                            </tr>
                        
                        @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="custom-color-with-td">
                                   <td></td>   
                                <td ><b>Total</b></td>
                                <td><b>{{ number_format($tt,2)}} </b></td>
                                    
                            </tr>
                        </tfoot>
                    </table>
                  
                </div>
            </div>
            <!-- /.panel-body -->
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
        dom: 'lBfrtip',

        buttons: [
          {extend: 'copyHtml5',title: 'CLIENT SUMMARY ', footer: true},
           {extend: 'excelHtml5',title: 'CLIENT SUMMARY' , footer: true},
           {extend: 'csvHtml5',title: 'CLIENT SUMMARY' , footer: true},
            {extend: 'pdfHtml5',title: 'CLIENT SUMMARY', footer: true},
            {extend: 'print',title: 'CLIENT SUMMARY' , footer: true}

                ],
        }
      );
     
    </script>


@endsection