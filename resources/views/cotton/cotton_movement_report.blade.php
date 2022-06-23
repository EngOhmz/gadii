@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Cotton Movement Report</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link @if(empty($id)) active show @endif" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Cotton Movement Report
                                    List</a>
                            </li>
                       

                        </ul>
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">

<br>
@php
$center=App\Models\Cotton\CollectionCenter::where('id',$account_id)->first();
@endphp

        <div class="panel-heading">
            <h6 class="panel-title">
                Cotton Movement Report
                @if(!empty($start_date))
                @if(!empty($center->name))
                    for the period: <b>{{$start_date}} to {{$end_date}} for {{$center->name}}</b>
                    @else
                    for the period: <b>{{$start_date}} to {{$end_date}}</b>
                @endif
                    
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
                    <label class="">Collection Center</label>
                    {!! Form::select('account_id',$chart_of_accounts,$account_id, array('class' => 'select2','id'=>'account_id','style'=>'width:100%','placeholder'=>'Select')) !!}
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

                    <table class="table table-striped table-condensed table-hover" id="tableExport" style="width:100%;">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th> Reference</th>
                           <th> Center</th>
                            <th>Received Date</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th>Total Cost</th>
                        </tr>
                        </thead>
                        <tbody>

                            @php                        
                        $balance=0;
                 $qty=0;
                   @endphp

                        @foreach($data as $key)
                      
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{$key->reference}}</td>
                                   <td>{{$key->location_id->name}}</td>
                                <td>{{Carbon\Carbon::parse($key->purchase_date)->format('d/m/Y')}} </td>
                                <td>{{ number_format($key->quantity,2) }}</td>
                                 <td>{{ number_format($key->price,2) }}</td>
                             <td>{{ number_format($key->purchase_amount,2) }}</td>
                                
                            </tr>
                           @php
                        
                        $balance+=$key->purchase_amount;
                         $qty+=$key->quantity;
                   @endphp
                        @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="custom-color-with-td">
                                <td colspan="3"></td>  
                                <td ><b>Total</b></td>
                                <td><b>{{ number_format($qty,2) }}</b></td>
                                <td colspan="1"></td>
                                     <td><b>{{ number_format($balance,2) }}</b></td>
    
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