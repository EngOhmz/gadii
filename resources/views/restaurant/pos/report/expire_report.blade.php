@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Expired Item Report</h4>
                    </div>
                    <div class="card-body">
                       
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">

<br>
        <div class="panel-heading">
            <h6 class="panel-title">
                
                @if(!empty($start_date))
                  For the period: <b>{{Carbon\Carbon::parse($start_date)->format('F Y')}}  to {{Carbon\Carbon::parse($end_date)->format('F Y')}}</b>
                @endif
            </h6>
        </div>

<br>
        <div class="panel-body hidden-print">
            {!! Form::open(array('url' => Request::url(), 'method' => 'post','class'=>'form-horizontal', 'name' => 'form')) !!}
            <div class="row">

               <div class="col-md-4">
                    <label class="">Start Date</label>
                   <input type="month"  class="form-control monthyear" name="start_date" required value="<?php
                if (!empty($start_date)) {
                    echo $start_date;
                } else {
                    echo date('Y-m', strtotime('first day of january this year'));
                }
                ?>">

                </div>
                <div class="col-md-4">
                    <label class="">End Date</label>
                     <input  name="end_date" type="month"  class="form-control monthyear" required value="<?php
                if (!empty($end_date)) {
                    echo $end_date;
                } else {
                    echo date('Y-m');
                }
                ?>">
                </div>
                
                <?php $a=  trim(json_encode($x), '[]');  ?>
                
               

                <div class="col-md-4">
                    <label class="">Location</label> 
                   
                    <select name="location_id" class="form-control m-b" id="location_id" required>
                        <option value="">Select Location</option>
                        @if(!empty($location[0]))
                       
                        @foreach($location as $br)
                        <option value="{{$br->id}}" @if(isset($location_id)){{  $location_id == $br->id  ? 'selected' : ''}} @endif>{{$br->name}}</option>
                        @endforeach
                         <option value="<?php echo trim(json_encode($x), '[]');; ?>" @if(isset($location_id)){{ $location_id == $a  ? 'selected' : ''}} @endif>All Location</option>
                        @endif
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


 @if(isset($location_id))
     @php
     if($location_id == $a){
         $loc_id=$x;
     }
     
     else{
         
      $loc_id=$z;    
     }
     
     @endphp
     @endif


        <div class="panel panel-white">
            <div class="panel-body ">
                <div class="table-responsive">

                  <table class="table datatable-button-html5-basic">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Total Quantity</th>
                            
                        </tr>
                        </thead>
                        <tbody>

                          <?php
            $total=0; 
              
           $i=0; 
?>

                        @foreach($data as $key)

                         @php
                    $pqty= App\Models\POS\SerialList::where('brand_id', $key->id)->where('status','5')->whereIn('location',$loc_id)->whereBetween('expire_date',[$start_date,$end_date])->sum('quantity');
                              
                                        
                                        @endphp 

                            @if($pqty > 0)
                            <?php   $i++;  ?>

                            <tr>
                              <td>{{ $i }}</td>
                     <td><a  href="#view{{$key->id}}"  data-toggle="modal" >{{$key->name}}</a></td>

                                     @php
                                              
                                        $total+=$pqty;
                                            
                                        @endphp 

                                  <td>{{number_format($pqty,2)}}</td>
                                                         
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
  <div class="modal fade " data-backdrop=""  id="view{{$key->id}}"  tabindex="-1" role="dialog" aria-hidden="true">
                          <div class="modal-dialog modal-lg"><div class="modal-dialog  modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"  style="text-align:center;"> {{$key->name}} Disposed Balance<h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>


        <div class="modal-body">
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
                                                    style="width: 110.484px;">Expire Date</th>
                                                                                                
                                                  <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 100.484px;">Location</th>
                                                     <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 100.484px;">Quantity</th>
                                            </tr>
                                        </thead>
 <tbody>
                    <?php                   
                          $account =App\Models\POS\SerialList::where('brand_id', $key->id)->where('status','5')->whereIn('location',$loc_id)->whereBetween('expire_date',[$start_date,$end_date])
                                        ->orderBy('expire_date','desc')->groupBy('expire_date')->get();
                        ?>  
                 @foreach($account  as $a)
                                            <tr>
                                              <td >{{$loop->iteration }}</td>
                                         <td ><?php echo date('F Y', strtotime($a->expire_date)); ?></td>
                                <td >@if(!empty($a->location)){{$a->store->name }}@endif</td>
                                
                                     <?php                   
                                       
                                          $exp_qty =App\Models\POS\SerialList::where('brand_id', $key->id)->where('status','5')->whereIn('location',$loc_id)->where('expire_date', $a->expire_date)
                                        ->groupBy('expire_date')->sum('quantity'); 
                                                ?> 
                                                
                                      <td>{{ number_format($exp_qty,2) }}</td>    
                                            </tr> 
                        
                          @endforeach
                            </tbody>
                         
                         <?php
                                           
                                                $q = App\Models\POS\SerialList::where('brand_id', $key->id)->where('status','5')->whereIn('location',$loc_id)->whereBetween('expire_date',[$start_date,$end_date])->sum('quantity');
                                            
                                                ?>  
                        <tfoot>
                                            <tr>     
                                                     <td></td> <td></td>
                                                     <td><b> Total Balance</b></td>
                                                    <td><b>{{ number_format($q,2) }}</b></td>
                                                
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
          {extend: 'copyHtml5',title: 'EXPIRED ITEM REPORT FOR THE PERIOD {{Carbon\Carbon::parse($start_date)->format('F Y')}} TO {{Carbon\Carbon::parse($end_date)->format('F Y')}} ', footer: true},
           {extend: 'excelHtml5',title: 'EXPIRED ITEM REPORT FOR THE PERIOD {{Carbon\Carbon::parse($start_date)->format('F Y')}} TO {{Carbon\Carbon::parse($end_date)->format('F Y')}}' , footer: true},
           {extend: 'csvHtml5',title: 'EXPIRED ITEM REPORT FOR THE PERIOD {{Carbon\Carbon::parse($start_date)->format('F Y')}} TO {{Carbon\Carbon::parse($end_date)->format('F Y')}}' , footer: true},
            {extend: 'pdfHtml5',title: 'EXPIRED ITEM REPORT FOR THE PERIOD {{Carbon\Carbon::parse($start_date)->format('F Y')}} TO {{Carbon\Carbon::parse($end_date)->format('F Y')}}', footer: true,customize: function(doc) {
doc.content[1].table.widths = [ '10%', '50%', '30%'];
}
},
            {extend: 'print',title: 'EXPIRED ITEM REPORT FOR THE PERIOD {{Carbon\Carbon::parse($start_date)->format('F Y')}} TO {{Carbon\Carbon::parse($end_date)->format('F Y')}}' , footer: true}

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