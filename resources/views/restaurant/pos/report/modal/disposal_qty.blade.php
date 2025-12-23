    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"  style="text-align:center;"> {{$key->name}} @if(!empty($key->color)) - {{$key->c->name}} @endif   @if(!empty($key->size)) - {{$key->s->name}} @endif Disposed Quantity<h5>
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
                                                    style="width: 100.484px;">Quantity</th>
                                                       <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 100.484px;">Total</th>
                                             
                                            </tr>
                                        </thead>
 <tbody>
                    <?php                   
                          $account =App\Models\POS\GoodDisposalItem::leftJoin('pos_good_disposal', 'pos_good_disposal.id','pos_good_disposal_items.disposal_id')
                                                          ->where('item_id', $key->id)
                                                           ->whereIn('pos_good_disposal.location',$loc_id)
                                                           ->where('pos_good_disposal_items.status',1)     
                                                             ->whereBetween('date',[$start_date,$end_date])    
                                                           ->select('pos_good_disposal.*','pos_good_disposal_items.*')
                                                              ->get()  ;
                        ?>  
                 @foreach($account  as $a)
                                 <tr>
                      <td >{{$loop->iteration }}</td>
                        <td> {{$a->name }}</td>
                    <td> {{$a->date }}</td>
                   <td >@if(!empty($a->location)){{$a->store->name }}@endif</td>
                   <td >{{ number_format($a->quantity ,2) }}</td>
                         <td >{{ number_format($a->quantity * $key->cost_price ,2) }}</td>
                    </tr> 

  @endforeach
    </tbody>
 
 <?php
                   
                       
                  $q =App\Models\POS\GoodDisposalItem::leftJoin('pos_good_disposal', 'pos_good_disposal.id','pos_good_disposal_items.disposal_id')
                                                          ->where('item_id', $key->id)
                                                           ->whereIn('pos_good_disposal.location',$loc_id)
                                                           ->where('pos_good_disposal_items.status',1)     
                                                             ->whereBetween('date',[$start_date,$end_date])    
                                                           ->select('pos_good_disposal.*','pos_good_disposal_items.*')
                                                              ->sum('pos_good_disposal_items.quantity')  ;

                    
                        ?>  
<tfoot>
                    <tr>     
                        <td ></td> <td ></td><td ></td>
                             <td><b> Total Balance</b></td>
                              <td><b>{{ number_format($q,2) }}</b></td>
                            <td><b>{{ number_format($q * $key->cost_price,2) }}</b></td>
                        
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
             order: [[1, 'desc']],
             
             columnDefs: [
        { orderable: true, className: 'reorder', targets: 0 },
        { orderable: false, targets: '_all' }
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

