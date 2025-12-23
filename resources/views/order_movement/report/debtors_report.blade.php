@extends('layouts.master')


@section('content')

<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Debtors Report</h4>
                    </div>
                    <div class="card-body">
                       
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">

<br>
@php
$center=App\Models\Client::where('id',$account_id)->first();
$sign=App\Models\Currency::where('code',$currency)->first();
@endphp

        <div class="panel-heading">
            <h6 class="panel-title">
                @if(!empty($start_date))
                    For the period: <b>{{Carbon\Carbon::parse($start_date)->format('d/m/Y')}} to {{Carbon\Carbon::parse($end_date)->format('d/m/Y')}} for {{$center->name}} in {{$sign->name}}</b>
                @endif
            </h6>
        </div>

<br>
        <div class="panel-body hidden-print">
            {!! Form::open(array('url' => Request::url(), 'method' => 'post','class'=>'form-horizontal', 'name' => 'form')) !!}
            <div class="row">

                <div class="col-md-3">
                    <label class="">Start Date</label>
                   <input  name="start_date" type="date" class="form-control date-picker" required value="<?php
                if (!empty($start_date)) {
                    echo $start_date;
                } else {
                    echo date('Y-m-d', strtotime('first day of january this year'));
                }
                ?>">

                </div>
                <div class="col-md-3">
                    <label class="">End Date</label>
                     <input  name="end_date" type="date" class="form-control date-picker" required value="<?php
                if (!empty($end_date)) {
                    echo $end_date;
                } else {
                    echo date('Y-m-d');
                }
                ?>">
                </div>
                <div class="col-md-3">
                    <label class="">Debtors List</label>
                    {!! Form::select('account_id',$chart_of_accounts,$account_id, array('class' => 'm-b','id'=>'account_id','placeholder'=>'Select','style'=>'width:100%','required'=>'required')) !!}                 
                </div>

 <div class="col-md-3">
                    <label class="">Currency</label>
                    {!! Form::select('currency',$accounts,$currency, array('class' => 'm-b','id'=>'currency','placeholder'=>'Select','style'=>'width:100%','required'=>'required')) !!}
                  
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
$total_amount=0;
$total_invoice_due=0;
$total_due=0;
?>
                   <table class="table datatable-basic" id="example">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th> Ref</th>
                            <th> Invoice Date</th>
                      <th> Invoice Amount</th>
                            <th>Amount Received</th>
                         <th> Due Amount</th>
                            <th> Days Past Invoice Date</th>
                        </tr>
                        </thead>
                        <tbody>

                          <?php
            $total1 = $total2 = $total3 = $total4 = $total5 = $total6= $total7= 0; 
?>

                        @foreach($data as $key)
                          <?php
                        $dueDate = strtotime($key->date);
                          $todayDate= strtotime(date('d-m-Y'));
                          $datediff = $dueDate - $todayDate;
                           round($datediff / (60 * 60 * 24));
                          $dateDifferences = round($datediff / (60 * 60 * 24));
                         $invoice_due =$key->amount-$key->due_amount;
                           if( $dateDifferences < 0) {
                           $days= abs($dateDifferences);
                          }
                        else{
                              $days= 0;
                       } 
                        ?>
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                      <td><a href="{{ route('invoice.details', $key->id)}}">{{$key->confirmation_number}}</a></td>
                      <td>{{Carbon\Carbon::parse($key->date)->format('d/m/Y')}} </td>
                     <td>{{number_format($key->amount,2)}} {{$key->currency_code}}</td>
                           <td>{{number_format($invoice_due,2)}} {{$key->currency_code}}</td>                                                       
                            <td>{{number_format($key->due_amount,2)}} {{$key->currency_code}}</td>                      
                                           <td> 
                                                 @if($key->status == 0 )
                                             {{$days }}
                                            @elseif($key->status == 1)
                                              {{$days }}
                                            @elseif($key->status == 2)
                                           
                                            @elseif($key->status == 7)
                                           
                                            @endif
                                             </td>                                
                            </tr>
                        
                        <?php
$total_amount+=$key->amount;
$total_invoice_due+=$invoice_due;
$total_due+=$key->due_amount;
?>
                        @endforeach
                        </tbody>
                        <tfoot>
 <tr>
                                <td></td>
                      <td></td>
                      <td>Total</td>
                     <td>{{number_format($total_amount,2)}} {{$currency}}</td>
                           <td>{{number_format($total_invoice_due,2)}} {{$currency}}</td>                                                       
                            <td>{{number_format($total_due,2)}} {{$currency}}</td>                      
                                           <td>   </td>   

                                                                        
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
          {extend: 'copyHtml5',title: 'DEBTORS REPORT ', footer: true},
           {extend: 'excelHtml5',title: 'DEBTORS REPORT' , footer: true},
           {extend: 'csvHtml5',title: 'DEBTORS REPORT' , footer: true},
            {extend: 'pdfHtml5',title: 'DEBTORS REPORT', footer: true},
            {extend: 'print',title: 'DEBTORS REPORT' , footer: true}

                ],
        }
      );
     
    </script>


@endsection