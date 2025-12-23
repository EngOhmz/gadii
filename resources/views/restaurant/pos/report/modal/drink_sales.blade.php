    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"  style="text-align:center;"> {{$key->name}} @if(!empty($key->color)) - {{$key->c->name}} @endif   @if(!empty($key->size)) - {{$key->s->name}} @endif Sales Balance<h5>
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
                                                    style="width: 100.484px;">Date</th>
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
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 100.484px;">Amount</th>
                                             
                                            </tr>
                                        </thead>
 <tbody>
                    <?php     
              
                        $account =App\Models\Restaurant\POS\OrderHistory::where('item_id', $key->id)->where('item_type', 'Bar')->whereIn('location',$loc_id)->whereBetween('invoice_date',[$start_date,$end_date])->orderBy('invoice_date','desc')->get();
                        ?>  
                 @foreach($account  as $a)
                                 <tr>
                      <td >{{$loop->iteration }}</td>
                        <td >{{$a->invoice_date }}</td>
                        
                          <td >{{$a->invoice->reference_no }}</td>
                          <td >@if(!empty($a->client->name)){{$a->client->name }}@endif</td>
                         <td >@if(!empty($a->store->name)) {{$a->store->name }} @endif</td>
                         <td >{{ number_format($a->quantity ,2) }}</td>
                              <td >{{ number_format($a->quantity * $a->price ,2) }}</td>
                         
                   
                    </tr> 

  @endforeach
    </tbody>
 
 <?php
                   
                    $q = App\Models\Restaurant\POS\OrderHistory::where('item_id', $key->id)->where('item_type', 'Bar')->where('type', 'Sales')->whereIn('location',$loc_id)->whereBetween('invoice_date',[$start_date,$end_date])->sum('quantity');
                   $tqty=App\Models\Restaurant\POS\OrderHistory::where('item_id', $key->id)->where('item_type', 'Bar')->where('type', 'Sales')->whereIn('location',$loc_id)->whereBetween('invoice_date',[$start_date,$end_date])->sum(\DB::raw('quantity * price'));
                     
                    
                        ?>  
<tfoot>
                    <tr>     
                       <td ></td>
                             <td></td>   <td></td><td></td>
                         <td><b> Total Balance</b></td>
                            <td><b>{{ number_format($q,2) }}</b></td>
                              <td><b>{{ number_format($tqty ,2) }}</b></td>
                        
                    </tr> 

                      
 
                              </tfoot>
                            </table>
                           </div>

        </div>
        <div class="modal-footer bg-whitesmoke br">
            <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        </div>
    </div>
    
@yield('scripts') 
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

