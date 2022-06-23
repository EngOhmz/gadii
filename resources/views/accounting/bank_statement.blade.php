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
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link @if(empty($id)) active show @endif" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Bank Statement
                                    List</a>
                            </li>
                       

                        </ul>
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">

<br>
@php
$bank=App\Models\AccountCodes::where('id',$account_id)->first();
@endphp

        <div class="panel-heading">
            <h6 class="panel-title">
                Bank Statement
                @if(!empty($start_date))
                    for the period: <b>{{$start_date}} to {{$end_date}} for {{$bank->account_name}}</b>
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
                    {!! Form::select('account_id',$chart_of_accounts,$account_id, array('class' => 'select2', 'id'=>'account_id', 'placeholder'=>'Select','required'=>'required')) !!}
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
                      <table class="table table-striped table-condensed table-hover" id="tableExport" style="width:100%;">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th> Type</th>
                            <th>Date</th>
                            <th>Balance</th>
                            <th>Running Balance</th>
                            <th>Notes</th>
                        </tr>
                        </thead>
                        <tbody>

                            @php
                            $t_balance= 0;
                            $open_balance= 0;

                           @endphp
                            <tr>
                                <td></td>
                                <td></td>
                                
                                
                                <td><b>Open Balance</b></td>
                                <td>{{ number_format(0,2) }}</td>
                                 
                                <td>{{ number_format($open_debit-$open_credit,2) }}</td>
                                
                                <td></td>
                                 <tr>

                        @foreach($data as $key)

                        @php
                        
                             $balance=$key->debit -$key->credit;
                               $t_balance+= $balance;
                               $open_balance+= $open_debit-$open_credit;
                        @endphp
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                @if ($balance < 0)
                                <td>Withdraw</td>
                                @else
                                <td>Deposit</td>
                                @endif
                                <td>{{ $key->date }}</td>
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
<script>
$(document).ready(function() {
    new TomSelect("#account_id",{
        create: false,
        sortField: {
            field: "text",
            direction: "asc"
        }
    });
    $('.dataTables-example').DataTable({
        pageLength: 25,
        responsive: true,
        dom: '<"html5buttons"B>lTfgitp',
        buttons: [{
                extend: 'copy'
            },
            {
                extend: 'csv'
            },
            {
                extend: 'excel',
                title: 'ExampleFile'
            },
            {
                extend: 'pdf',
                title: 'ExampleFile'
            },

            {
                extend: 'print',
                customize: function(win) {
                    $(win.document.body).addClass('white-bg');
                    $(win.document.body).css('font-size', '10px');

                    $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', 'inherit');
                }
            }
        ]

    });

});
</script>
<script src="{{ url('assets/js/plugins/sweetalert/sweetalert.min.js') }}"></script>

@endsection