    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"  style="text-align:center;"> {{$key->name}} Movement Quantity<h5>
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
                                                    style="width: 100.484px;">Serial</th>
                                                     <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 100.484px;">Date</th>                                             
                                                  <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 100.484px;">Source Location</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 100.484px;"> Destination Location</th>
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
                          $account =App\Models\GoodMovementItem::leftJoin('good_movements', 'good_movements.id','good_movement_items.movement_id')
                                                          ->where('brand_id', $key->id)
                                                          ->whereIn('good_movement_items.destination_store',$loc_id)
                                                           ->where('good_movement_items.status',1)     
                                                             ->whereBetween('movement_date',[$start_date,$end_date])    
                                                           ->select('good_movements.*','good_movement_items.*')
                                                              ->get()  ;
                        ?>  
                 @foreach($account  as $a)
                                 <tr>
                      <td >{{$loop->iteration }}</td>
                        <td> {{$a->name }}</td>
                         <td> @php $s = App\Models\InventoryList::find($a->item_id); @endphp @if(!empty($s)){{$s->serial_no }}@endif</td>
                    <td> {{$a->movement_date }}</td>
                  <td>@if(!empty($a->source->name)) {{$a->source->name}} @endif</td>
                 <td>@if(!empty($a->destination->name)) {{$a->destination->name}} @endif</td>
                   <td >{{ number_format($a->quantity ,2) }}</td>
                         <td >{{ number_format($a->quantity * $key->price ,2) }}</td>
                    </tr> 

  @endforeach
    </tbody>
 
 <?php
               
                   
                       
                  $q =App\Models\GoodMovementItem::leftJoin('good_movements', 'good_movements.id','good_movement_items.movement_id')
                                                          ->where('brand_id', $key->id)
                                                          ->whereIn('good_movement_items.destination_store',$loc_id)
                                                           ->where('good_movement_items.status',1)     
                                                             ->whereBetween('movement_date',[$start_date,$end_date])    
                                                           ->select('good_movements.*','good_movement_items.*')
                                                              ->sum('good_movement_items.quantity')  ;

                    
                        ?>  
<tfoot>
                    <tr>     
                        <td ></td> <td ></td><td ></td><td ></td><td></td>
                             <td><b> Total Balance</b></td>
                              <td><b>{{ number_format($q,2) }}</b></td>
                            <td><b>{{ number_format($q * $key->price,2) }}</b></td>
                        
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

