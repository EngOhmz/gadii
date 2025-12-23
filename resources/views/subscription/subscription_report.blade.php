@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Subscription Payment Report</h4>
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
                            <th>Name</th>
                            <th>Total</th>
                            
                        </tr>
                        </thead>
                        <tbody>

                          <?php
            $total=0; 
             $tt=0; 
           $i=0; 
?>

                        @foreach($data as $key)
                        
                        

                         @php $tt=DB::table('integration_deposits')->where('user_id', $key->added_by)->where('status', '2')->whereBetween('created_at',[$start_date,$end_date])->sum('amount'); @endphp

                            @if($tt > 0)
                            <?php   $i++;  ?>

                            <tr>
                              <td>{{ $i }}</td>
                     <td><a  href="#view{{$key->added_by}}"  data-toggle="modal" >{{$key->name}}</a></td>

                                     @php
                                              
                                        $total+=$tt;
                                            
                                        @endphp 

                                  <td>{{number_format($tt,2)}}</td>
                                                         
                            </tr>
                        @endif
                        @endforeach
                        </tbody>
                        <tfoot>
                           <tr>
                                <td>Total</td>
                     <td></td>
                           <td>{{number_format($total,2)}}</td>
                                                             
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

 <!-- Modal -->
 @if(!empty($start_date))
@foreach($data as $key)
  <div class="modal fade " data-backdrop=""  id="view{{$key->added_by}}"  tabindex="-1" role="dialog" aria-hidden="true">
                          <div class="modal-dialog modal-lg"><div class="modal-dialog  modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"  style="text-align:center;"> {{$key->name}} Subscription Details<h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>


       <div class="modal-body">
       <?php $q=0; ?>
  <div class="table-responsive">
                           <table class="table datatable-basic table-striped">
                                       <thead>
                                            <tr>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Browser: activate to sort column ascending"
                                                    style="width: 30.531px;">#</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 120.484px;">Reference</th>  
                                                     <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 100.484px;">Date</th>                                             
                                                  <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 100.484px;">Role</th>
                                                     <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 100.484px;">Amount</th>
                                                     <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 100.484px;">Status</th>
                                             
                                            </tr>
                                        </thead>
 <tbody>
                    <?php                   
        $account =DB::table('integration_deposits')->where('user_id', $key->added_by)->where('status', '2')->whereBetween('created_at',[$start_date,$end_date])->orderBy('id','desc')->get()  ;
                        ?>  
                 @foreach($account  as $a)
                  @php $role=App\Models\Role::find($a->role_id); @endphp
                                 <tr>
                      <td >{{$loop->iteration }}</td>
                        <td>{{$a->reference_no}}</td>
                        <td>{{ Carbon\Carbon::parse($a->created_at)->format('d/m/Y')}} </td>
                         <td>@if(!empty($role)){{$role->slug}}@endif</td>
                        <td>{{number_format($a->amount,2)}}</td>

                        <td>
                        @if($a->status == 1)
                       <div class="badge badge-info badge-shadow"> In Process</div>
                        @elseif($a->status == 2)
                        <div class="badge badge-success badge-shadow"> Success</div>
                        @elseif($a->status == 3)
                        <div class="badge badge-danger badge-shadow"> Transaction Failed</div>
                        @endif
                        </td>
                                                
                    </tr>
                    
                    <?php $q+=$a->amount ; ?>

  @endforeach
    </tbody>
 
<tfoot>
                    <tr>     
                        <td ></td> <td ></td><td ></td>
                             <td><b> Total </b></td>
                              <td><b>{{ number_format($q,2) }}</b></td>
                            <td></td>
                        
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
        dom: 'lBfrtip',

        buttons: [
          {extend: 'copyHtml5',title: 'SUBSCRIPTION PAYMENT REPORT FOR THE PERIOD {{Carbon\Carbon::parse($start_date)->format('d/m/Y')}} TO {{Carbon\Carbon::parse($end_date)->format('d/m/Y')}} ', footer: true},
           {extend: 'excelHtml5',title: 'SUBSCRIPTION PAYMENT REPORT FOR THE PERIOD {{Carbon\Carbon::parse($start_date)->format('d/m/Y')}} TO {{Carbon\Carbon::parse($end_date)->format('d/m/Y')}}' , footer: true},
           {extend: 'csvHtml5',title: 'SUBSCRIPTION PAYMENT REPORT FOR THE PERIOD {{Carbon\Carbon::parse($start_date)->format('d/m/Y')}} TO {{Carbon\Carbon::parse($end_date)->format('d/m/Y')}}' , footer: true},
            {extend: 'pdfHtml5',title: 'SUBSCRIPTION PAYMENT REPORT FOR THE PERIOD {{Carbon\Carbon::parse($start_date)->format('d/m/Y')}} TO {{Carbon\Carbon::parse($end_date)->format('d/m/Y')}}', footer: true,customize: function(doc) {
doc.content[1].table.widths = [ '10%', '50%', '30%'];
}
},
            {extend: 'print',title: 'SUBSCRIPTION PAYMENT REPORT FOR THE PERIOD {{Carbon\Carbon::parse($start_date)->format('d/m/Y')}} TO {{Carbon\Carbon::parse($end_date)->format('d/m/Y')}}' , footer: true}

                ],
        }
      );
     
    </script>
<script>
       $('.datatable-basic').DataTable({
            autoWidth: false,
            "columnDefs": [
                {"orderable": false, "targets": [1]}
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
<script src="{{ url('assets/js/plugins/sweetalert/sweetalert.min.js') }}"></script>

@endsection