@extends('layouts.master')


@section('content')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
 
 
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
  <script>
    jQuery(document).ready(function($) {
      $('#example').DataTable(
        {
        dom: 'Bfrtip',
        buttons: [
                    'copy',
                    'excel',
                    'csv',
                    'pdf',
                    'print'
                ],
        }
      );
     
    } );
    </script>
    
    
    
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Truck Summary</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link @if(empty($id)) active show @endif" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Truck Summary
                                    List</a>
                            </li>
                       

                        </ul>
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">

<br>
@php
$center=App\Models\Truck::where('id',$account_id)->first();
@endphp

        <div class="panel-heading">
            <h6 class="panel-title">
             Truck Summary
                @if(!empty($start_date))
                    for the period: <b>{{$start_date}} to {{$end_date}} </b>
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


   <div class="col-md-4">
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

                    <table class="table table-striped" id="example" style="width:100%;">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th> Truck/Driver</th>
                       <th> No of Trips</th>
                        <th> Income Generated</th>
                            <th>Truck Expenses</th>
                          
                    <th>Mileage</th>
                  <th>Road Toll</th>
                   <th>Toll Gate</th>
                       <th>Council</th>
                         <th>Consultant</th>
                            <th>Refill</th>
                        <th>Damaged Bags</th>
                        </tr>
                        </thead>
                        <tbody>
                          <?php
                        $tt = 0;
                        $ti = 0;
                          $te = 0;
                         $ts = 0;
                        $tm = 0;                      
                         $trt= 0;
                         $ttg= 0;
                         $tc= 0;
                          $ted= 0;
                        $tr= 0;
                           $tb= 0;
?>
                        @foreach($data as $key)
                          <?php
                      

                       if(!empty($start_date)){
                      $trips = \App\Models\CargoLoading::where('added_by',auth()->user()->added_by)->where('truck_id',$key->id)->whereBetween('collection_date',[$start_date,$end_date])->count('id');
                           $income = \App\Models\JournalEntry::where('added_by',auth()->user()->added_by)->where('truck_id',$key->id)->where('transaction_type','cargo')->whereBetween('date',[$start_date,$end_date])->sum('debit');
                       $expenses= \App\Models\JournalEntry::where('added_by',auth()->user()->added_by)->where('truck_id',$key->id)->where('account_id',$repair->id)->whereBetween('date',[$start_date,$end_date])->sum('debit');
                    
                     $mileage = \App\Models\Mileage::where('added_by',auth()->user()->added_by)->where('truck_id',$key->id)->whereBetween('date',[$start_date,$end_date])->sum('total_mileage');
                       $road=  \App\Models\CargoLoading::where('added_by',auth()->user()->added_by)->where('truck_id',$key->id)->whereBetween('collection_date',[$start_date,$end_date])->sum('road_toll');
                    $gate=  \App\Models\CargoLoading::where('added_by',auth()->user()->added_by)->where('truck_id',$key->id)->whereBetween('collection_date',[$start_date,$end_date])->sum('toll_gate');
                   $council=  \App\Models\CargoLoading::where('added_by',auth()->user()->added_by)->where('truck_id',$key->id)->whereBetween('collection_date',[$start_date,$end_date])->sum('council');
                 $ed=  \App\Models\CargoLoading::where('added_by',auth()->user()->added_by)->where('truck_id',$key->id)->whereBetween('collection_date',[$start_date,$end_date])->sum('consultant');
                       $refill = \App\Models\Fuel\Refill::where('added_by',auth()->user()->added_by)->where('truck',$key->id)->whereBetween('date',[$start_date,$end_date])->sum('total_cost');
                        $bags =  \App\Models\CargoLoading::vwhere('truck_id',$key->id)->whereBetween('collection_date',[$start_date,$end_date])->sum('damaged');
                       }
                        else{
                           
                         $trips = \App\Models\CargoLoading::where('added_by',auth()->user()->added_by)->where('truck_id',$key->id)->count('id');
                           $income = \App\Models\JournalEntry::where('added_by',auth()->user()->added_by)->where('truck_id',$key->id)->where('transaction_type','cargo')->sum('debit');
                       $expenses= \App\Models\JournalEntry::where('added_by',auth()->user()->added_by)->where('truck_id',$key->id)->where('account_id',$repair->id)->sum('debit');
                   
                     $mileage = \App\Models\Mileage::where('added_by',auth()->user()->added_by)->where('truck_id',$key->id)->sum('total_mileage');
                   $road=  \App\Models\CargoLoading::where('added_by',auth()->user()->added_by)->where('truck_id',$key->id)->sum('road_toll');
                    $gate=  \App\Models\CargoLoading::where('added_by',auth()->user()->added_by)->where('truck_id',$key->id)->sum('toll_gate');
                   $council=  \App\Models\CargoLoading::where('added_by',auth()->user()->added_by)->where('truck_id',$key->id)->sum('council');
                 $ed=  \App\Models\CargoLoading::where('added_by',auth()->user()->added_by)->where('truck_id',$key->id)->sum('consultant');
                       $refill = \App\Models\Fuel\Refill::where('added_by',auth()->user()->added_by)->where('truck',$key->id)->sum('total_cost');
                        $bags =  \App\Models\CargoLoading::where('added_by',auth()->user()->added_by)->where('truck_id',$key->id)->sum('damaged');
                      }

                    $tt += $trips;
                        $ti +=$income;
                          $te += $expenses;
                      
                        $tm +=$mileage;
                          $trt+=$road;
                         $ttg+=$gate;
                         $tc+=$council;;
                          $ted+=$ed;;
                        $tr += $refill;
                           $tb+= $bags;
 
                        ?>
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                 <td>{{ $key->reg_no}} 
                                           @if($key->driver != '')
                                          - {{$key->assign->driver_name }}
                                                    @else
                                                          @endif
                                                     </td>
                                    <td>{{ number_format($trips,2)}} </td>
                                    <td>{{ number_format($income,2)}}</td>
                                     <td>{{ number_format($expenses,2)}}</td>
                                   
                                <td>{{ number_format($mileage,2)}}</td>
                           <td>{{ number_format($road,2)}}</td>
                             <td>{{ number_format($gate,2)}}</td>
                           <td>{{ number_format($council,2)}}</td>
                         <td>{{ number_format($ed,2)}}</td>
                                    <td>{{ number_format($refill,2)}}</td>
                                <td>{{ number_format($bags,2)}}</td>  
                                
                            </tr>
                        
                        @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="custom-color-with-td">
                                   <td></td>   
                                <td ><b>Total</b></td>
                                <td><b>{{ number_format($tt,2)}} </b></td>
                                    <td><b>{{ number_format($ti,2)}}</b></td>
                                     <td><b>{{ number_format($te,2)}}</b></td>
                                    
                                <td><b>{{ number_format($tm,2)}}</b></td>
                                  <td>{{ number_format($trt,2)}}</td>
                             <td>{{ number_format($ttg,2)}}</td>
                           <td>{{ number_format($tc,2)}}</td>
                         <td>{{ number_format($ted,2)}}</td>
                                    <td><b>{{ number_format($tr,2)}}</b></td>
                                <td><b>{{ number_format($tb,2)}}</b></td>  
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
<script>
       $('.datatable-basic').DataTable({
            autoWidth: false,
            "columnDefs": [
                {"targets": [3]}
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

@endsection