@extends('layouts.master')


@section('content')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
 
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
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
                    { extend: 'copy', footer: true },
                    
                    { extend: 'excel', footer: true},
                    
                    { extend: 'csv', footer: true },
                    
                    { extend: 'pdf', footer: true },
                   
                    { extend: 'print', footer: true }
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
                        <h4> Courier Cost Report</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link @if(empty($id)) active show @endif" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">  Courier Cost Report
                                    List</a>
                            </li>
                       

                        </ul>
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">

<br>

        <div class="panel-heading">

            <h6 class="panel-title">
              Courier Cost Report
                @if(!empty($start_date))
                    for the period: <b>{{$start_date}} to {{$end_date}}</b>
                @endif

            </h6>
        </div>

<br>
        <div class="panel-body hidden-print">
            {!! Form::open(array('url' => Request::url(), 'method' => 'post','class'=>'form-horizontal', 'name' => 'form')) !!}
            <div class="row">

                <div class="col-md-4">
                    <label class="">Start Date</label>
                   <input  name="start_date" type="date" class="form-control date-picker"  required value="<?php
                if (!empty($start_date)) {
                    echo $start_date;
                } else {
                    echo date('Y-m-d', strtotime('first day of january this year'));
                }
                ?>">

                </div>
                <div class="col-md-4">
                    <label class="">End Date</label>
                     <input  name="end_date" type="date" class="form-control date-picker"  required value="<?php
                if (!empty($end_date)) {
                    echo $end_date;
                } else {
                    echo date('Y-m-d');
                }
                ?>">
                </div>
<!--
                <div class="col-md-4">
                    <label class="">Courier Reference No</label>
                    {!! Form::select('account_id',$chart_of_accounts,$account_id, array('class' => 'form-control m-b','id'=>'account_id','placeholder'=>'Select','style'=>'width:100%','required'=>'required')) !!}
                </div>
-->

   <div class="col-md-4">
                      <br><button type="submit" class="btn btn-success">Search</button>
                        <a href="{{Request::url()}}"class="btn btn-danger">Reset</a>

                </div>                  
                </div>
           
            {!! Form::close() !!}

        </div>

        <!-- /.panel-body -->

   <br> <br>
@if(!empty($start_date))
        <div class="panel panel-white">
            <div class="panel-body ">
                <div class="table-responsive">

<!-- /.admin side -->
                    
                    <table class="table  table-striped" id="example" style="width:100%;">
                        <thead>
                        <tr>
                         <th> Date</th>
                          <th> WB No</th>
                                <th> Customer</th>
                                <th>Tariff</th>                            
                             <th>Location</th>
                               <th>Pickup </th>
                           <th>Packaging </th>
                             <th>Freight </th>
                                <th>Commission </th>
                            <th>Delivery </th>
                        <th>Total </th> 
                            <th>Invoice </th>
                     <th>Profit/Loss</th>
                        </tr>
                        </thead>
                        <tbody>
                           <?php
                         
                       $p=0;
                       $pck=0;
                        $l=0;
                         $o=0;
                         $d=0;
                         $total=0;
                         $invoice=0;
                       ?>

                        @foreach($data as $key)
                          <?php
                         

                        $pickup=\App\Models\Courier\CourierActivity::where('collection_id',$key->id)->where('activity','Confirm Pickup')->first();
                         $pack=\App\Models\Courier\CourierActivity::where('collection_id',$key->id)->where('activity','Confirm Packaging')->first();
                       $loading=\App\Models\Courier\CourierActivity::where('collection_id',$key->id)->where('activity','Confirm Freight')->first();
                   $off=\App\Models\Courier\CourierActivity::where('collection_id',$key->id)->where('activity','Confirm Commission')->first();
                      $delivery=\App\Models\Courier\CourierActivity::where('collection_id',$key->id)->where('activity','Confirm Delivery')->first();

                     if(!empty($pickup->costs)){
                        $total_p=$pickup->costs;
                      }
                       else{
                           $total_p=0;
                   }
                  if(!empty($packaging->costs)){
                        $total_pck=$packaging->costs;
                      }
                       else{
                           $total_pck=0;
                   }
                  if(!empty($loading->costs)){
                        $total_l=$loading->costs;
                      }
                       else{
                           $total_l=0;
                   }
                if(!empty($off->costs)){
                        $total_o=$off->costs;
                      }
                       else{
                           $total_o=0;
                   }
                if(!empty($delivery->costs)){
                        $total_d=$delivery->costs;
                      }
                       else{
                           $total_d=0;
                   }

                        $p+=  $total_p;
                         $pck+=$total_pck;
                         $l+=  $total_l;
                         $o+=  $total_o;
                         $d+=  $total_d;                             
                         $invoice+= $key->amount;

                        ?>
                            <tr>
                                  <td>{{Carbon\Carbon::parse($key->collection_date)->format('d/m/Y')}} </td>
                             <td>{{$key->wbn_no}} </td> 
                                             <td>{{$key->client->name}}</td>

                                     <td>@if(!empty($key->route->zone_name)) {{$key->route->zone_name}} - {{$key->route->weight}}  @else {{$key->tariff_id }} @endif </td>                                
                               <td> {{$key->start->name}} - {{$key->end->name}}</td> 
                          <td>{{!empty( $pickup->costs)? number_format( $pickup->costs,2) : number_format(0,2)}} </td>   
                            <td>{{!empty( $pack->costs)? number_format( $pack->costs,2) : number_format(0,2)}} </td>                                
                         <td>{{!empty($loading->costs)? number_format($loading->costs,2) : number_format(0,2)}} </td> 
                          <td>{{!empty($off->costs)? number_format($off->costs,2) : number_format(0,2)}} </td> 
                            <td>{{!empty($delivery->costs)? number_format($delivery->costs,2) : number_format(0,2)}} </td> 
                              <td>{{ number_format($total_p+ $total_pck+ $total_l + $total_o + $total_d,2) }}</td> 
                               <td>{{ number_format($key->amount,2) }}</td>  
                       <td>{{ number_format(($key->amount)-($total_p+ $total_pck+ $total_l + $total_o + $total_d),2) }}</td>   
                            </tr>
                        
                        @endforeach
                        </tbody>
                        <tfoot>
                         <tr>
                                  <td> </td>
                             <td></td> 
                                    <td></td>
                                <td></td> 
                                <td><strong>Total</strong></td>  
                          <td>{{!empty( $p)? number_format( $p,2) : number_format(0,2)}} </td> 
                             <td>{{!empty( $pck)? number_format( $pck,2) : number_format(0,2)}} </td>                                
                         <td>{{!empty($l)? number_format($l,2) : number_format(0,2)}} </td> 
                          <td>{{!empty($o)? number_format($o,2) : number_format(0,2)}} </td> 
                            <td>{{!empty($d)? number_format($d,2) : number_format(0,2)}} </td> 
                              <td>{{ number_format($p+ $l + $o + $d,2) }}</td> 
                               <td>{{ number_format($invoice,2) }}</td> 
                           <td>{{ number_format(($invoice)-($p+ $pck + $l + $o + $d),2) }}</td>
                             
                            </tr>
                        
                    </tfoot>
                    </table>
                   @endif
<!-- /.admin side -->


           
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
                {"orderable": false, "targets": [3]}
            ],
           dom: '<"datatable-scroll"t><"datatable-footer"ip>',
            "language": {
               search: '<span>Filter:</span> _INPUT_',
                searchPlaceholder: 'Type to filter...',
                lengthMenu: '<span>Show:</span> _MENU_',
             paginate: { 'first': 'First', 'last': 'Last', 'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;', 'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;' }
            },
        
        });
    </script>
<script src="{{ url('assets/js/plugins/sweetalert/sweetalert.min.js') }}"></script>

@endsection