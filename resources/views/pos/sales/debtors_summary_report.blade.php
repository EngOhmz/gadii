@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Debtors Summary Report</h4>
                    </div>
                    <div class="card-body">
                        
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">

<br>
@php
$money=App\Models\Currency::where('code',$currency)->first();
@endphp

        <div class="panel-heading">
            <h6 class="panel-title">
             
                @if(!empty($start_date))
                    From <b>{{Carbon\Carbon::parse($start_date)->format('d/m/Y')}}  to {{Carbon\Carbon::parse($end_date)->format('d/m/Y')}} in {{$money->name}}</b>
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
                    <label class="">Currency</label>
                    {!! Form::select('currency',$accounts,$currency, array('class' => 'm-b','id'=>'currency','placeholder'=>'Select','style'=>'width:100%','required'=>'required')) !!}
                  
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
@if(!empty($start_date))
        <div class="panel panel-white">
            <div class="panel-body ">
                <div class="table-responsive">

<?php
$total_a=0;
$total_d=0;
?>
    
                 <table class="table datatable-button-html5-basic">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Debtor</th>
                      <th> Invoice Amount</th>
                            <th>Paid Amount</th>
                            <th>Due Amount</th>
                        </tr>
                        </thead>
                        <tbody>

                         @foreach($data as $key)
                         
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                      <td><a  href="#view{{$key->client_id}}"  data-toggle="modal" >{{$key->client->name}}</a></td>

                                                          @php
        $amount= App\Models\POS\Invoice::where('client_id', $key->client_id)->where('exchange_code', $currency)->where('status','!=',0)->where('added_by',auth()->user()->added_by)->whereBetween('invoice_date',[$start_date,$end_date])->sum(\DB::raw(' (invoice_amount +invoice_tax + shipping_cost)  - discount '));

   $due= App\Models\POS\Invoice::where('client_id', $key->client_id)->where('exchange_code', $currency)->where('status','!=',0)->where('added_by',auth()->user()->added_by)->whereBetween('invoice_date',[$start_date,$end_date])->sum('due_amount');
                                         @endphp

                              <td>{{number_format($amount,2)}} </td>
                                 <td>{{number_format($amount-$due,2)}} </td>  
                                 <td>{{number_format($due,2)}}  </td> 
                                                        
                            </tr>
                        
<?php
$total_a+=$amount;
$total_d+=$due;
?>
                        @endforeach
                        

                        </tbody>
                        <tfoot>
                        <tr>
<td></td>
<td><b>Total</b></td>
  <td>{{number_format($total_a,2)}} </td>
 <td>{{number_format(($total_a-$total_d),2)}} </td>  
 <td>{{number_format($total_d,2)}}  </td> 
</tr>
                   <tfoot>
                        
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

 <!-- Modal -->
@foreach($data as $key)
  <div class="modal fade " data-backdrop=""  id="view{{$key->client_id}}"  tabindex="-1" role="dialog" aria-hidden="true">
                          <div class="modal-dialog modal-lg"><div class="modal-dialog  modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"  style="text-align:center;"> {{$key->client->name}} Summary Report<h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>


        <div class="modal-body">
  <div class="table-responsive">
  
  <?php
$total_amount=0;
$total_invoice_due=0;
$total_due=0;
?>
                           <table class="table datatable-basic table-striped">
                                       <thead>
                                            <tr>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Browser: activate to sort column ascending"
                                                    style="width: 30.531px;">#</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Browser: activate to sort column ascending"
                                                    style="width: 30.531px;">Ref</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 110.484px;">Invoice Date</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 120.484px;">Invoice Amount</th>                                               
                                              <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 160.484px;">Amount Paid</th>
                                                  <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 100.484px;">Due Amount</th>
                                                     
                                             
                                            </tr>
                                        </thead>
 <tbody>
                    <?php      
                    
                        $account =App\Models\POS\Invoice::where('client_id', $key->client_id)->where('exchange_code', $currency)->whereBetween('invoice_date',[$start_date,$end_date])->where('status','!=',0)->where('added_by',auth()->user()->added_by)->get();
                        ?>  
                 @foreach($account  as $a)
                 
                 <?php
                  $invoice_due =(($a->invoice_amount +$a->invoice_tax +  $a->shipping_cost ) - $a->discount)  - $a->due_amount;
                  ?>
                                 <tr>
                      <td >{{$loop->iteration }}</td>
                      <td>{{$a->reference_no}}</td>
                       <td>{{Carbon\Carbon::parse($a->invoice_date)->format('d/m/Y')}} </td>
                       <td>{{number_format(($a->invoice_amount +$a->invoice_tax +  $a->shipping_cost ) - $a->discount ,2)}} </td> 
                        <td>{{number_format($invoice_due,2)}} </td>
                        <td>{{number_format($a->due_amount,2)}} </td> 
                      
                    </tr> 
                    
                      <?php
$total_amount+=(($a->invoice_amount +$a->invoice_tax +  $a->shipping_cost ) - $a->discount);
$total_invoice_due+=$invoice_due;
$total_due+=$a->due_amount;
?>

  @endforeach
    </tbody>
 
 
<tfoot>
                    <tr>     
                        
                                <td></td>
                      <td></td>
                      <td>Total</td>
                     <td>{{number_format($total_amount,2)}}</td>
                           <td>{{number_format($total_invoice_due,2)}} </td>                                                       
                            <td>{{number_format($total_due,2)}} </td> 
                        
                    </tr> 

                      
 
                              </tfoot>
                            </table>
                           </div>

        </div>
        <div class="modal-footer bg-whitesmoke br">
            <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        </div>
    </div>
</div></div>
  </div>

@endforeach


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

    $('.datatable-button-html5-basic').DataTable(
      {
      dom: 'Bfrtip',

      buttons: [
        {extend: 'copyHtml5',title: 'DEBTORS SUMMARY REPORT FROM {{Carbon\Carbon::parse($start_date)->format('d-m-Y')}} TO {{Carbon\Carbon::parse($end_date)->format('d-m-Y')}} @if(!empty($start_date)) IN {{$money->name}} @endif ', footer: true},
         {extend: 'excelHtml5',title: 'DEBTORS SUMMARY REPORT FROM {{Carbon\Carbon::parse($start_date)->format('d-m-Y')}} TO {{Carbon\Carbon::parse($end_date)->format('d-m-Y')}} @if(!empty($start_date)) IN {{$money->name}} @endif', footer: true},
         {extend: 'csvHtml5',title: 'DEBTORS SUMMARY REPORT FROM {{Carbon\Carbon::parse($start_date)->format('d-m-Y')}} TO {{Carbon\Carbon::parse($end_date)->format('d-m-Y')}} @if(!empty($start_date)) IN {{$money->name}} @endif', footer: true},
          {extend: 'pdfHtml5',title: 'DEBTORS SUMMARY REPORT FROM {{Carbon\Carbon::parse($start_date)->format('d-m-Y')}} TO {{Carbon\Carbon::parse($end_date)->format('d-m-Y')}} @if(!empty($start_date)) IN {{$money->name}} @endif', footer: true,customize: function(doc) {doc.content[1].table.widths = [  '8%', '20%', '24%', '24%','24%']; }},
          {extend: 'print',title: 'DEBTORS SUMMARY REPORT FROM {{Carbon\Carbon::parse($start_date)->format('d-m-Y')}} TO {{Carbon\Carbon::parse($end_date)->format('d-m-Y')}} @if(!empty($start_date)) IN {{$money->name}} @endif' , footer: true}

              ],
      }
    );
   
  </script>

@endsection