@extends('layouts.master')


@section('content')


    
    
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Truck Report</h4>
                    </div>
                    <div class="card-body">
                        
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">

<br>
@php
$center=App\Models\Truck::where('id',$account_id)->first();
@endphp

        <div class="panel-heading">
            <h6 class="panel-title">
                @if(!empty($start_date))
                    For the period: <b>{{Carbon\Carbon::parse($start_date)->format('d/m/Y')}} to {{Carbon\Carbon::parse($end_date)->format('d/m/Y')}} for {{$center->truck_name}} - {{$center->reg_no}}</b>
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
                    <label class="">Truck Name</label>
                    {!! Form::select('account_id',$chart_of_accounts,$account_id, array('class' => 'form-control  m-b','id'=>'account_id','placeholder'=>'Select','style'=>'width:100%','required'=>'required')) !!}
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
                   
                        $cr = \App\Models\JournalEntry::where('added_by', auth()->user()->added_by)->where('truck_id', $account_id)->whereBetween('date',
                            [$start_date, $end_date])->sum('credit');
                        $dr = \App\Models\JournalEntry::where('added_by', auth()->user()->added_by)->where('truck_id', $account_id)->whereBetween('date',
                            [$start_date, $end_date])->sum('debit');
                      
                        ?>

                    <table class="table datatable-button-html5-basic">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th> Date</th>
                        <th> Account Name</th>
                            <th>Debit </th>
                            <th>Credit</th>
                            <th>Notes</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($data as $key)
                          <?php
                       
                        $cr = \App\Models\JournalEntry::where('added_by', auth()->user()->added_by)->where('truck_id', $account_id)->whereBetween('date',
                            [$start_date, $end_date])->sum('credit');
                        $dr = \App\Models\JournalEntry::where('added_by', auth()->user()->added_by)->where('truck_id', $account_id)->whereBetween('date',
                            [$start_date, $end_date])->sum('debit');
                      
                        ?>
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                  <td>{{Carbon\Carbon::parse($key->date)->format('d/m/Y')}} </td>
                                    <td>{{ $key->chart->account_name }}</td>
                                    <td>{{ number_format($key->debit,2) }}</td>
                                <td>{{ number_format($key->credit,2) }}</td>  
                             <td>{{ $key->notes }}</td>
                                
                            </tr>
                        
                        @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="custom-color-with-td">
                                   <td></td>  <td></td>  
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
          {extend: 'copyHtml5',title: 'TRUCK REPORT @if(!empty($start_date)) FOR THE PERIOD {{Carbon\Carbon::parse($start_date)->format('d/m/Y')}} TO {{Carbon\Carbon::parse($end_date)->format('d/m/Y')}} FOR {{$center->truck_name}} - {{$center->reg_no}} @endif ', footer: true},
           {extend: 'excelHtml5',title: 'TRUCK REPORT @if(!empty($start_date)) FOR THE PERIOD {{Carbon\Carbon::parse($start_date)->format('d/m/Y')}} TO {{Carbon\Carbon::parse($end_date)->format('d/m/Y')}}  FOR {{$center->truck_name}} - {{$center->reg_no}} @endif' , footer: true},
           {extend: 'csvHtml5',title: 'TRUCK REPORT @if(!empty($start_date)) FOR THE PERIOD {{Carbon\Carbon::parse($start_date)->format('d/m/Y')}} TO {{Carbon\Carbon::parse($end_date)->format('d/m/Y')}}  FOR {{$center->truck_name}} - {{$center->reg_no}} @endif' , footer: true},
            {extend: 'pdfHtml5',title: 'TRUCK REPORT @if(!empty($start_date)) FOR THE PERIOD {{Carbon\Carbon::parse($start_date)->format('d/m/Y')}} TO {{Carbon\Carbon::parse($end_date)->format('d/m/Y')}}  FOR {{$center->truck_name}} - {{$center->reg_no}} @endif', footer: true},
            {extend: 'print',title: 'TRUCK REPORT @if(!empty($start_date)) FOR THE PERIOD {{Carbon\Carbon::parse($start_date)->format('d/m/Y')}} TO {{Carbon\Carbon::parse($end_date)->format('d/m/Y')}}  FOR {{$center->truck_name}} - {{$center->reg_no}} @endif' , footer: true}

                ],
        }
      );
     
    </script>

@endsection