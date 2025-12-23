    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="formModal">Multiple Production Activity List</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

 {!! Form::open(['route' => ['work_order.store_produce',$id], 'method' => 'POST', 'id' => 'frm-example' , 'name' => 'frm-example']) !!}
   @csrf
  @method('PUT')
 <div class="modal-body">
<?php
$total=0;
?>

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
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 106.484px;">Ref</th>
                                               
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 106.484px;">Product</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 106.484px;">Work Center Store</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 106.484px;">Finish Store</th>    
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Produced Date</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Produced Quantity</th>
                                             <!--   <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Produced Quantity Returned On store</th>    
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Produced Quantity Remaining To Transfer on store</th> -->
                                                     
                                            </tr>
                                        </thead>
                                         <tbody>
                                            @if(!@empty($work))
                                            @foreach ($work as $row)
                                            <tr class="gradeA even" role="row">
                                                <th>{{ $loop->iteration }}</th>
                                                    

                                                    @php
                                                 $account=App\Models\Manufacturing\WorkOrder::where('id',$row->work_order_id)->first();
                                                @endphp
                                               @if(!empty($account))
                                                <td>{{$account->reference_no}}</td>
                                              @else
                                                <td></td>
                                              @endif

                                                      
                                                <td>{{$row->product}}</td> 
                                                
                                                @php
                                                 $account2=App\Models\Location::where('id',$row->work_center_store)->first();
                                                @endphp
                                                @if(!empty($account2))
                                                <td>{{$account2->name}}</td>
                                                  @else
                                                    <td></td>
                                                  @endif
                                                  
                                                @php
                                                 $account3=App\Models\Location::where('id',$row->finish_store)->first();
                                                @endphp
                                                @if(!empty($account3))
                                                    <td>{{$account3->name}}</td>
                                                  @else
                                                    <td></td>
                                                  @endif
                                                
                                                     <td>{{$row->produced_date}}</td> 
                                                     
                                            <input type="hidden" name="work_id[]"
                                                                class="form-control"
                                                                value="{{$row->id}}"
                                                                 />
                                                                
                                                                
                                            <input type="hidden" name="quantity[]"
                                                                class="form-control"
                                                                value="{{$row->quantity_rem}}"
                                                                 />
                                                                

                                                  <td>{{number_format($row->quantity_rem,3)}}</td>
                                                  
                                                <!--  <td>{{number_format($row->quantity_store,2)}}</td>
                                                  
                                                  <td>{{number_format($row->quantity_rem,3)}}</td> -->
                                                                           
                       

                              
                                            </tr>
<?php
                 $total+=$row->quantity_produced;
?>
                                            @endforeach

                                            @endif

                                        </tbody>
<tfoot>
<td></td><td></td><td></td>
<td></td><td></td>
<td><b>Total</b></td>
<td><b>{{number_format($total,3)}}</b> </td>
</tfoot>
                                    </table>
                                </div>
                                                    </div>


        
        <div class="modal-footer">
           
            <button class="btn btn-link" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i> Close</button>
        </div>
  {!! Form::close() !!}
    </div>

@yield('scripts')
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




