@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Inventory Report</h4>
                    </div>
                    <div class="card-body">
                        
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">


        <div class="panel panel-white">
            <div class="panel-body ">
                <div class="table-responsive">

                  <table class="table datatable-button-html5-basic">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                              <th>Purchase Balance</th>
                               <th>Sales Balance</th>
                            <th>Total Balance</th>
                        </tr>
                        </thead>
                        <tbody>

                          <?php
            $total_p=0; 
             $total_s=0;
             $total_pr=0; 
             $total_sr=0;
             $total_i=0;  
                $i=0;      
?>

                        @foreach($data as $key)

                        @php
                                      $pqty= App\Models\POS\PurchaseHistory::where('item_id', $key->id)->where('type', 'Purchases')->sum('quantity');   
                                        $dn= App\Models\POS\PurchaseHistory::where('item_id', $key->id)->where('type', 'Debit Note')->sum('quantity');  
                                        $iqty= App\Models\POS\GoodIssueItem::where('item_id', $key->id)->where('status',1)->sum('quantity');                                        
                                       $sqty= App\Models\POS\InvoiceHistory::where('item_id', $key->id)->where('type', 'Sales')->sum('quantity'); 
                                          $cn= App\Models\POS\InvoiceHistory::where('item_id', $key->id)->where('type', 'Credit Note')->sum('quantity');  
                                        @endphp 

                                @if($pqty-$dn > 0 || $sqty-$cn > 0 )

                            <?php   $i++;  ?>

                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                 <td>{{$key->name}}</td>

                                 @php  
                                        $total_p+=$pqty;
                                        $total_pr+=$dn;                                      
                                        $total_i+=$iqty;
                                          $total_s+=$sqty;
                                        $total_sr+=$cn;
                                        @endphp 

                           <td><a  href="#viewp{{$key->id}}"  data-toggle="modal" >{{number_format($pqty-$dn,2)}}</a></td>
                                 <td><a  href="#views{{$key->id}}"  data-toggle="modal" >{{number_format($sqty-$cn,2)}}</a></td>     
                              <td>{{number_format(($pqty-$dn)-($sqty-$cn),2)}}</td>                          
                            </tr>

                        @endif
                        @endforeach
                        </tbody>
                        <tfoot>
                           <tr>
                                <td>Total</td>
                     <td></td>
                           <td>{{number_format($total_p - $total_pr,2)}}</td>
                                <td>{{number_format($total_s - $total_sr,2)}}</td>
                       <td>{{number_format(($total_p- $total_pr) -($total_s- $total_sr),2)}}</td>                               
                            </tr>
                        </tfoot>
                    </table>
                  
                </div>
            </div>
            <!-- /.panel-body -->
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

    </div>
</section>

 <!-- Modal -->
@foreach($data as $key)
  <div class="modal fade " data-backdrop=""  id="viewp{{$key->id}}"  tabindex="-1" role="dialog" aria-hidden="true">
                          <div class="modal-dialog modal-lg"><div class="modal-dialog  modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"  style="text-align:center;"> {{$key->name}} Purchase Balance<h5>
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
                                                    style="width: 50.484px;">Type</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 110.484px;">Date</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 120.484px;">Ref No</th>                                               
                                              <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 160.484px;">Supplier</th>
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
                                                $account =App\Models\POS\PurchaseHistory::where('item_id', $key->id)->orderBy('purchase_date','desc')->get();
                                                ?>  
                                         @foreach($account  as $a)
                                                         <tr>
                                              <td >{{$loop->iteration }}</td>
                                              <td >{{$a->type }}</td>
                                              @if($a->type == 'Purchases')
                                              <td >{{$a->purchase_date }}</td>
                                               @else
                                                    <td >{{$a->return_date }}</td>
                                                   @endif
                                                  <td >@if(!empty($a->purchase_id)) {{$a->purchase->reference_no }} @endif</td>
                          <td >@if(!empty($a->supplier_id)){{$a->supplier->name }}@endif</td>
                   <td >@if(!empty($a->location)){{$a->store->name }}@endif</td>
                                           @if($a->type == 'Purchases')
                                           <td >{{ number_format($a->quantity ,2) }}</td>
                                           @else
                                                  <td >{{ number_format(0-$a->quantity ,2) }}</td>
                                               @endif
                                            </tr> 
                        
                          @endforeach
                            </tbody>
                         
                         <?php
                                           
                                                $q = App\Models\POS\PurchaseHistory::where('item_id', $key->id)->where('type', 'Purchases')->sum('quantity');
                                                $r = App\Models\POS\PurchaseHistory::where('item_id', $key->id)->where('type', 'Debit Note')->sum('quantity');
                                            
                                                ?>  
                        <tfoot>
                                            <tr>     
                                                <td ></td> <td ></td>
                                                     <td></td> <td></td>
                                                   <td></td>  <td><b> Total Balance</b></td>
                                                    <td><b>{{ number_format($q-$r,2) }}</b></td>
                                                
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

@foreach($data as $key)
  <div class="modal fade " data-backdrop=""  id="viewi{{$key->id}}"  tabindex="-1" role="dialog" aria-hidden="true">
                          <div class="modal-dialog modal-lg"><div class="modal-dialog  modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"  style="text-align:center;"> {{$key->name}} Issued Balance<h5>
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
                                                    style="width: 120.484px;">Reference</th>  
                                                     <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 100.484px;">Date</th>                                             
                                                  <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 100.484px;">Location</th>
                                                 <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 100.484px;">Truck</th>
                                                     <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 100.484px;">Quantity</th>
                                             
                                            </tr>
                                        </thead>
 <tbody>
                    <?php                   
                        $account =App\Models\POS\GoodIssueItem::where('item_id', $key->id)->where('status',1)->get();
                        ?>  
                 @foreach($account  as $a)
                                 <tr>
                      <td >{{$loop->iteration }}</td>
                        <td> {{$a->issue->name }}</td>
                    <td> {{$a->issue->date }}</td>
                   <td >@if(!empty($a->location)){{$a->store->name }}@endif</td>
                  <td>@if(!empty($a->truck_id)) {{$a->truck->reg_no }} {{$a->truck->truck_name }} @endif</td>
                   <td >{{ number_format($a->quantity ,2) }}</td>
                    </tr> 

  @endforeach
    </tbody>
 
 <?php
                   
                        $q = App\Models\POS\GoodIssueItem::where('item_id', $key->id)->where('status',1)->sum('quantity');

                    
                        ?>  
<tfoot>
                    <tr>     
                        <td ></td> <td ></td><td ></td><td ></td>
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

@foreach($data as $key)
  <div class="modal fade " data-backdrop=""  id="views{{$key->id}}"  tabindex="-1" role="dialog" aria-hidden="true">
                          <div class="modal-dialog modal-lg"><div class="modal-dialog  modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"  style="text-align:center;"> {{$key->name}} Sales Balance<h5>
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
                                                    style="width: 50.484px;">Type</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 110.484px;">Date</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 120.484px;">Ref No</th>                                               
                                              <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 160.484px;">Client</th>
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
                                                $account =App\Models\POS\InvoiceHistory::where('item_id', $key->id)->orderBy('invoice_date','desc')->get();
                                                ?>  
                                         @foreach($account  as $a)
                                                         <tr>
                                              <td >{{$loop->iteration }}</td>
                                               <td >{{$a->type }}</td>
                                                @if($a->type == 'Sales')
                                                <td >{{$a->invoice_date }}</td>
                                                 @else
                                                      <td >{{$a->return_date }}</td>
                                                     @endif
                                                  <td >{{$a->invoice->reference_no }}</td>
                                                  <td >{{$a->client->name }}</td>
                                           <td >@if(!empty($a->location)){{$a->store->name }}@endif</td>
                                                       @if($a->type == 'Sales')
                                                 <td >{{ number_format($a->quantity ,2) }}</td>
                                                 @else
                                                        <td >{{ number_format(0-$a->quantity ,2) }}</td>
                                                     @endif
                                           
                                            </tr> 
                        
                          @endforeach
                            </tbody>
                         
                         <?php
                                           
                                                $q = App\Models\POS\InvoiceHistory::where('item_id', $key->id)->where('type', 'Sales')->sum('quantity');
                                                 $r = App\Models\POS\InvoiceHistory::where('item_id', $key->id)->where('type', 'Credit Note')->sum('quantity');
                                                ?>  
                        <tfoot>
                                            <tr>     
                                                <td ></td> <td ></td>
                                                     <td></td>   <td></td><td></td>
                                                 <td><b> Total Balance</b></td>
                                                    <td><b>{{ number_format($q-$r,2) }}</b></td>
                                                
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
          {extend: 'copyHtml5',title: 'INVENTORY REPORT ', footer: true},
           {extend: 'excelHtml5',title: 'INVENTORY REPORT' , footer: true},
           {extend: 'csvHtml5',title: 'INVENTORY REPORT' , footer: true},
            {extend: 'pdfHtml5',title: 'INVENTORY REPORT', footer: true,customize: function(doc) {
doc.content[1].table.widths = [ '8%', '32%', '20%', '20%','20%'];
}
},
            {extend: 'print',title: 'INVENTORY REPORT' , footer: true}

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