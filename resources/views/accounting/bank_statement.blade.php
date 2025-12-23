@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Bank Statement</h4>
                    </div>
                    <div class="card-body">
                       
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">

<br>
@php
$bank=App\Models\AccountCodes::where('id',$account_id)->first();
@endphp

        <div class="panel-heading">
            <h6 class="panel-title">
               
                @if(!empty($start_date))
                    For the period: <b>{{Carbon\Carbon::parse($start_date)->format('d/m/Y')}}  to {{Carbon\Carbon::parse($end_date)->format('d/m/Y')}} for {{$bank->account_name}}</b>
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
                    <label class="">Bank</label>
                    {!! Form::select('account_id',$chart_of_accounts,$account_id, array('class' => 'form-control m-b ', 'id'=>'account_id', 'placeholder'=>'Select','required'=>'required')) !!}
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
                      <caption style="caption-side: top;color:black;text-align:center;"><b>NOTE - OPEN BALANCE : {{ number_format($open_debit-$open_credit,2) }}</b></caption><br><br>
                        <thead>
                        <tr>
                            <th>#</th>
                            <th> Type</th>
                            <th>Date</th>
                            <th>Amount</th>
                            <th> Balance</th>
                            <th>Notes</th>
                        </tr>
                        </thead>
                        <tbody>

                            @php
                            $t_balance= 0;
                            $open_balance= 0;

                           @endphp
                            

                        @foreach($data as $key)

                        @php
                        
                             $balance=$key->debit -$key->credit;
                               $t_balance+= $balance;
                               $open_balance= $open_debit-$open_credit;
                        @endphp
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                @if ($balance < 0)
                                <td>Withdraw</td>
                                @else
                                <td>Deposit</td>
                                @endif
                                <td>{{Carbon\Carbon::parse($key->date)->format('d/m/Y')}}</td>
                                <td>{{ number_format(abs($balance),2) }}</td>
                                 
                                <td>{{ number_format($t_balance +$open_balance ,2) }}</td>
                                <td>{{$key->notes }}</td>
                            </tr>
                        @endforeach
                        </tbody>
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
          "ordering": false,
        dom: 'lBfrtip',

        buttons: [
          {extend: 'copyHtml5',title: 'BANK STATEMENT ', footer: true},
           {extend: 'excelHtml5',title: 'BANK STATEMENT' , footer: true},
           {extend: 'csvHtml5',title: 'BANK STATEMENT' , footer: true},
            {extend: 'pdfHtml5',title: 'BANK STATEMENT FROM {{Carbon\Carbon::parse($start_date)->format('d/m/Y')}}  TO {{Carbon\Carbon::parse($end_date)->format('d/m/Y')}} @if(!empty($start_date)) FOR {{$bank->account_name}} @endif', footer: true},
            {extend: 'print',title: 'BANK STATEMENT' , footer: true}

                ],
        }
      );
     
    </script>

@endsection