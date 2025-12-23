@extends('layouts.master')


@section('content')
        
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Payments Report</h4>
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
                            <th>Account Name</th>
                            <th>Amount</th>

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
                                
                                @php
                                $account=App\Models\AccountCodes::where('id',$key->account_id)->first();
                                $amount=App\Models\Expenses::where('account_id',$key->account_id)->where('status','1')->whereBetween('date',[$start_date,$end_date])->where('added_by',auth()->user()->added_by)->sum('amount');
                                @endphp
                                
                                @if(!empty($account))
                                <td>{{$account->account_name}}</td>
                                @else
                                <td></td>
                                @endif
                                
                                <td><a  href="#view{{$key->account_id}}"  data-toggle="modal" >{{ number_format($amount,2) }}</a></td>
                            </tr>
<?php
$dr+=$amount;
?>
                        @endforeach
                        </tbody>
 <tfoot>
                            <tr class="custom-color-with-td">
                                   <td></td>    
                                <td ><b>Total</b></td>
                                <td><b>{{ number_format($dr,2) }}</b></td>
                                   
                                    
    
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


 @if(!empty($start_date))
@foreach($data as $key)
@php
$account=App\Models\AccountCodes::where('id',$key->account_id)->first();
@endphp

  <div class="modal fade " data-backdrop=""  id="view{{$key->account_id}}"  tabindex="-1" role="dialog" aria-hidden="true">
 <div class="modal-dialog modal-lg"><div class="modal-dialog  modal-lg" role="document">

    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"  style="text-align:center;"> {{$account->account_name}} Details<h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>


<?php
$total=0;
?>
        <div class="modal-body">
  <div class="table-responsive">
                         <table class="table datatable-modal table-striped"  id="table-list">
                                       <thead>
                                            <tr>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Browser: activate to sort column ascending"
                                                    style="width: 98.531px;">#</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Date</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 106.484px;">Reference</th>

                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Payment Account</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Amount</th>
                                                      
                                                
                                            </tr>
                                        </thead>
                                         @php
                                $expense=App\Models\Expenses::where('account_id',$key->account_id)->where('status','1')->whereBetween('date',[$start_date,$end_date])->where('added_by',auth()->user()->added_by)->get();
                                @endphp
                                         <tbody>
                                            @if(!@empty($expense))
                                            @foreach ($expense as $row)
                                            <tr class="gradeA even" role="row">
                                                <th>{{ $loop->iteration }}</th>
                                                 <td>{{Carbon\Carbon::parse($row->date)->format('d/m/Y')}}</td>
                                                     <td>{{$row->name}}</td>
                                                     
                                                     
                                                     
                                                    @php
                                                 $bank=App\Models\AccountCodes::where('id',$row->bank_id)->first();
                                                @endphp
                                                
                                                <td>{{$bank->account_name}}</td> 
                                                
                                                  <td>{{number_format($row->amount,2)}}</td>
                                                  
                               
<?php
                 $total+=$row->amount;
?>
                                            @endforeach

                                            @endif

                                        </tbody>
<tfoot>
<td></td><td></td><td></td>
<td><b>Total</b></td>
<td><b>{{number_format($total,2)}}</b> </td>
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
@endif

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
          {extend: 'copyHtml5',title: 'PAYMENTS REPORT FOR THE PERIOD {{Carbon\Carbon::parse($start_date)->format('d-m-Y')}} TO {{Carbon\Carbon::parse($end_date)->format('d-m-Y')}} ', footer: true},
           {extend: 'excelHtml5',title: 'PAYMENTS REPORT FOR THE PERIOD {{Carbon\Carbon::parse($start_date)->format('d-m-Y')}} TO {{Carbon\Carbon::parse($end_date)->format('d-m-Y')}}' , footer: true},
           {extend: 'csvHtml5',title: 'PAYMENTS REPORT FOR THE PERIOD {{Carbon\Carbon::parse($start_date)->format('d-m-Y')}} TO {{Carbon\Carbon::parse($end_date)->format('d-m-Y')}}' , footer: true},
            {extend: 'pdfHtml5',title: 'PAYMENTS REPORT FOR THE PERIOD {{Carbon\Carbon::parse($start_date)->format('d-m-Y')}} TO {{Carbon\Carbon::parse($end_date)->format('d-m-Y')}}', footer: true,
           
},
            {extend: 'print',title: 'PAYMENTS REPORT FOR THE PERIOD {{Carbon\Carbon::parse($start_date)->format('d-m-Y')}} TO {{Carbon\Carbon::parse($end_date)->format('d-m-Y')}}' , footer: true}

                ],
        }
      );
     
    </script>
    
    <script>
       $('.datatable-modal').DataTable({
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


 <script>
        $(document).ready(function(){
            /*
                         * Multiple drop down select
                         */
            $('.m-b').select2({ width: '100%', });



        });
    </script>

@endsection