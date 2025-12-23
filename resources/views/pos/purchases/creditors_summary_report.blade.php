@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Creditors Summary Report</h4>
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
                            <th>Creditor</th>
                      <th> Purchase Amount</th>
                            <th>Paid Amount</th>
                            <th>Due Amount</th>
                        </tr>
                        </thead>
                        <tbody>

                         @foreach($data as $key)
                         
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                      <td>{{$key->supplier->name}}</td>

                                                          @php
        $amount= App\Models\POS\Purchase::where('supplier_id', $key->supplier_id)->where('exchange_code', $currency)->where('status','!=',0)->where('added_by',auth()->user()->added_by)->whereBetween('purchase_date',[$start_date,$end_date])->sum(\DB::raw('(purchase_amount +purchase_tax + shipping_cost)  - discount'));

   $due= App\Models\POS\Purchase::where('supplier_id', $key->supplier_id)->where('exchange_code', $currency)->where('status','!=',0)->where('added_by',auth()->user()->added_by)->whereBetween('purchase_date',[$start_date,$end_date])->sum('due_amount');
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
        {extend: 'copyHtml5',title: 'CREDITORS SUMMARY REPORT FROM {{Carbon\Carbon::parse($start_date)->format('d-m-Y')}} TO {{Carbon\Carbon::parse($end_date)->format('d-m-Y')}} @if(!empty($start_date)) IN {{$money->name}} @endif ', footer: true},
         {extend: 'excelHtml5',title: 'CREDITORS SUMMARY REPORT FROM {{Carbon\Carbon::parse($start_date)->format('d-m-Y')}} TO {{Carbon\Carbon::parse($end_date)->format('d-m-Y')}} @if(!empty($start_date)) IN {{$money->name}} @endif', footer: true},
         {extend: 'csvHtml5',title: 'CREDITORS SUMMARY REPORT FROM {{Carbon\Carbon::parse($start_date)->format('d-m-Y')}} TO {{Carbon\Carbon::parse($end_date)->format('d-m-Y')}} @if(!empty($start_date)) IN {{$money->name}} @endif', footer: true},
          {extend: 'pdfHtml5',title: 'CREDITORS SUMMARY REPORT FROM {{Carbon\Carbon::parse($start_date)->format('d-m-Y')}} TO {{Carbon\Carbon::parse($end_date)->format('d-m-Y')}} @if(!empty($start_date)) IN {{$money->name}} @endif', footer: true,customize: function(doc) {doc.content[1].table.widths = [  '8%', '20%', '24%', '24%','24%']; }},
          {extend: 'print',title: 'CREDITORS SUMMARY REPORT FROM {{Carbon\Carbon::parse($start_date)->format('d-m-Y')}} TO {{Carbon\Carbon::parse($end_date)->format('d-m-Y')}} @if(!empty($start_date)) IN {{$money->name}} @endif' , footer: true}

              ],
      }
    );
   
  </script>

@endsection