     <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"  style="text-align:center;"> {{$key->name}} @if(!empty($key->color)) - {{$key->c->name}} @endif   @if(!empty($key->size)) - {{$key->s->name}} @endif Return Issued Quantity<h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>

     
     <?php
     $qty=0;
     $balance=0;
     ?>       

        <div class="modal-body">
  <div class="table-responsive">
                           <table class="table datatable-basic table-striped">
                                       <thead>
                                            <tr>
                                               
                                               <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 20.484px;">#</th>
                                                   
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
                                                    style="width: 160.484px;">Staff</th>
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
                                          @foreach($account  as $a)
                                                         <tr>
                                                <td >{{$loop->iteration }}</td>
                                              <td >{{Carbon\Carbon::parse($a->date)->format('d/m/Y') }}</td>
                                              <td>
                                        @php $pr = App\Models\POS\Purchase::find($a->purchase_id); $ir = App\Models\POS\Invoice::find($a->invoice_id); @endphp
                              @if($a->type == 'Purchases')  @if(!empty($pr)) {{$pr->reference_no }}@endif 
                              @elseif($a->type == 'Sales') @if(!empty($ir)) {{$ir->reference_no }}@endif
                              @elseif($a->type == 'Debit Note') @php $dnr = App\Models\POS\ReturnPurchases::find($a->return_id);@endphp @if(!empty($dnr)) {{$dnr->reference_no }} @endif  @if(!empty($pr)) - {{$pr->reference_no }}@endif
                              @elseif($a->type == 'Credit Note') @php $cnr = App\Models\POS\ReturnInvoice::find($a->return_id); @endphp @if(!empty($cnr)) {{$cnr->reference_no }} @endif  @if(!empty($ir)) - {{$ir->reference_no }}@endif
                              @elseif($a->type == 'Stock Movement') @php $mr = App\Models\POS\StockMovement::find($a->other_id);@endphp  @if(!empty($mr)) {{$mr->name }}@endif
                              @elseif($a->type == 'Good Issue' || $a->type == 'Returned Good Issue') @php $ir = App\Models\POS\GoodIssue::find($a->other_id); @endphp @if(!empty($ir)) {{$ir->name }}@endif
                              @elseif($a->type == 'Good Disposal') @php $dr = App\Models\POS\GoodDisposal::find($a->other_id); @endphp @if(!empty($dr)) {{$dr->name }}@endif
                                              @endif
                                              </td>
                                              
                                              <td >
                                              @php $supp = App\Models\Supplier::find($a->supplier_id); @endphp @if(!empty($supp)) {{$supp->name }} @endif
                                              @php $client = App\Models\Client::find($a->client_id); @endphp @if(!empty($client)) {{$client->name }} @endif
                                              @php $user = App\Models\User::find($a->staff_id); @endphp @if(!empty($user)) {{$user->name }} @endif
                                             </td>
                                              <td> @php $store = App\Models\Location::find($a->location); @endphp @if(!empty($store)){{$store->name }}@endif</td>
                                             <td >{{ number_format($a->in ,2) }}</td>
                                              <td >{{ number_format($a->in * $a->price ,2) }}</td>
                                           
                                               
                                               
                                            </tr> 
                                            
                                            
                                             <?php
                                             $qty+=$a->in;
                                             $balance+=$a->in * $a->price;
                                             ?>

                        
                                        @endforeach   
                          
                            </tbody>
                         
                       <tfoot>
                            <tr>     

                            <td colspan="5"><b> Total</b></td>
                            <td><b>{{ number_format($qty,2) }}</b></td>
                             <td><b>{{ number_format($balance,2) }}</b></td>   
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
           
           dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
            "language": {
               search: '<span>Filter:</span> _INPUT_',
                searchPlaceholder: 'Type to filter...',
                lengthMenu: '<span>Show:</span> _MENU_',
             paginate: { 'first': 'First', 'last': 'Last', 'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;', 'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;' }
            },
        
        });
    </script>

