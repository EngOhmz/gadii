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
$sign=App\Models\Currency::where('code',$account_id)->first();
@endphp
        <div class="panel-heading">
            <h6 class="panel-title">
            
                @if(!empty($start_date))
                    For the period: <b>{{Carbon\Carbon::parse($start_date)->format('d/m/Y')}} to {{Carbon\Carbon::parse($end_date)->format('d/m/Y')}} in {{$sign->name}}</b>
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
                    {!! Form::select('account_id',$chart_of_accounts,$account_id, array('class' => 'm-b','id'=>'account_id','placeholder'=>'Select','style'=>'width:100%','required'=>'required')) !!}
                  
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
@if(!empty($start_date))
        <div class="panel panel-white">
            <div class="panel-body ">
                <div class="table-responsive">

<?php
$total_a=0;
$total_d=0;
?>
                    <table class="table datatable-basic" id="example">
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
                      <td>{{$key->supplier->name}}</td>

                                                          @php
                            $amount= App\Models\Pacel\PacelInvoice::where('added_by',auth()->user()->added_by)->where('owner_id', $key->owner_id)->where('currency_code', $account_id)->whereBetween('date',[$start_date,$end_date])->sum('amount');
                            $due= App\Models\Pacel\PacelInvoice::where('added_by',auth()->user()->added_by)->where('owner_id', $key->owner_id)->where('currency_code', $account_id)->whereBetween('date',[$start_date,$end_date])->sum('due_amount');
                                         @endphp

                              <td>{{number_format($amount,2)}}  {{ $account_id}}</td>
                                 <td>{{number_format($amount-$due,2)}}  {{ $account_id}}</td>  
                                 <td>{{number_format($due,2)}}  {{ $account_id}}</td> 
                                                        
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
  <td>{{number_format($total_a,2)}}  {{ $account_id}}</td>
 <td>{{number_format(($total_a-$total_d),2)}}  {{ $account_id}}</td>  
 <td>{{number_format($total_d,2)}}  {{ $account_id}}</td> 
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

      $('.datatable-basic').DataTable(
        {
        dom: 'lBfrtip',

        buttons: [
          {extend: 'copyHtml5',title: 'DEBTORS SUMMARY REPORT ', footer: true},
           {extend: 'excelHtml5',title: 'DEBTORS SUMMARY REPORT' , footer: true},
           {extend: 'csvHtml5',title: 'DEBTORS SUMMARY REPORT' , footer: true},
            {extend: 'pdfHtml5',title: 'DEBTORS SUMMARY REPORT', footer: true},
            {extend: 'print',title: 'DEBTORS SUMMARY REPORT' , footer: true}

                ],
        }
      );
     
    </script>



@endsection