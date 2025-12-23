@extends('layouts.master')


@section('content')
        
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Journal Entry Report</h4>
                    </div>
                    <div class="card-body">
                      
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">

<br>
        <div class="panel-heading">
            <h6 class="panel-title">
               @if(!empty($start_date))
                  For the period: <b>{{Carbon\Carbon::parse($start_date)->format('d/m/Y')}}  to {{Carbon\Carbon::parse($end_date)->format('d/m/Y')}}</b>
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
                    <label class="">Account</label>
                   <select class="form control m-b account" id="account_id" name="account_id" required>
                   <option value="">Select Account</option>
                     <option value="all" @if(isset($account_id)){{  $account_id == 'all'  ? 'selected' : ''}} @endif>All Accounts</option>
                   @foreach($chart_of_accounts as $group => $ch)
                   <optgroup label="{{$group}}"> @foreach($ch as $chart)
                   <option value="{{$chart->id}}" @if(isset($account_id)){{  $account_id == $chart->id  ? 'selected' : ''}} @endif>{{$chart->account_name}}</option>
                   @endforeach
                   </optgroup> 
                   @endforeach
              
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
                <div class="table-responsive">
                
                                    
                                    
                     <table class="table datatable-button-html5-basic">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th> Type</th>
                            <th>Date</th>
                            <th>Account Name</th>
                            <th>Debit</th>
                            <th>Credit</th>
                     <th>Notes</th>
                        </tr>
                        </thead>
                        <tbody>
<?php
$dr=0;
$cr=0;
?>
                        @foreach($data as $key)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{$key->transaction_type}}</td>
                                <td>{{Carbon\Carbon::parse($key->date)->format('d/m/Y')}}</td>
                                <td>
                                    @if(!empty($key->chart))
                                        {{ $key->chart->account_name }}
                                    @endif
                                </td>
                                 
                                <td>{{ number_format($key->debit,2) }}</td>
                                <td>{{ number_format($key->credit,2) }}</td>
                                 <td>{{ $key->notes }}</td>
                            </tr>
<?php
$dr+=$key->debit;
$cr+=$key->credit;
?>
                        @endforeach
                        </tbody>
 <tfoot>
                            <tr class="custom-color-with-td">
                                   <td></td>  <td></td> <td></td>  
                                <td ><b>Total</b></td>
                                <td><b>{{ number_format($dr,2) }}</b></td>
                                   <td><b>{{ number_format($cr,2) }}</b></td>
                                    <td></td>
                                    
    
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

      $('.datatable-button-html5-basic').DataTable(
        {
        dom: 'lBfrtip',

        buttons: [
          {extend: 'copyHtml5',title: 'JOURNAL ENTRY REPORT FOR THE PERIOD {{Carbon\Carbon::parse($start_date)->format('d-m-Y')}} TO {{Carbon\Carbon::parse($end_date)->format('d-m-Y')}} ', footer: true},
           {extend: 'excelHtml5',title: 'JOURNAL ENTRY REPORT FOR THE PERIOD {{Carbon\Carbon::parse($start_date)->format('d-m-Y')}} TO {{Carbon\Carbon::parse($end_date)->format('d-m-Y')}}' , footer: true},
           {extend: 'csvHtml5',title: 'JOURNAL ENTRY REPORT FOR THE PERIOD {{Carbon\Carbon::parse($start_date)->format('d-m-Y')}} TO {{Carbon\Carbon::parse($end_date)->format('d-m-Y')}}' , footer: true},
            {extend: 'pdfHtml5',title: 'JOURNAL ENTRY REPORT FOR THE PERIOD {{Carbon\Carbon::parse($start_date)->format('d-m-Y')}} TO {{Carbon\Carbon::parse($end_date)->format('d-m-Y')}}', footer: true,
           
},
            {extend: 'print',title: 'JOURNAL ENTRY REPORT FOR THE PERIOD {{Carbon\Carbon::parse($start_date)->format('d-m-Y')}} TO {{Carbon\Carbon::parse($end_date)->format('d-m-Y')}}' , footer: true}

                ],
        }
      );
     
    </script>


 <script>
        $(document).ready(function(){
            /*
                         * Multiple drop down select
                         */
            $('.m-b').select2({ width: '100%', });



        });
    </script>

@endsection