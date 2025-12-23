
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="formModal">Invoice List</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

 <div class="modal-body">

            <div class="table-responsive">
                                   <table class="table datatable-modal table-striped">
                                        <thead>
                                            <tr>

                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 156.484px;">Reference</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 186.484px;">Client Name</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 156.484px;">Invoice Date</th>
                                             
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Due Amount</th>
                                                    
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Status</th>

                                              

                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!@empty($purchases))
                                            @foreach ($purchases as $row)
                                            <tr class="gradeA even" role="row">
                                                <td><a href="{{ route('invoice.details', $row->id)}}">{{$row->pacel_number}}</a> </td>                                               
                                                <td>  {{$row->supplier->name}}   </td>
                                                <td>{{$row->date}}</td>
                                                <td>{{number_format($row->due_amount,2)}} {{$row->exchange_code}}</td>
                                                <td>
                                                   @if($row->status == 0)
                                                    <div class="badge badge-primary badge-shadow">Invoiced</div>
                                                    @elseif($row->status == 1)
                                                    <div class="badge badge-info badge-shadow">Partially Paid</div>
                                                    @elseif($row->status == 2)
                                                    <div class="badge badge-success badge-shadow">Paid Invoice</div>
                                                    @endif
                                                </td>
                                               
                                                
                                                <td>
                                                  
                                               
                                                        <a class="nav-link" id="profile-tab2"
                                                                    href="{{ route('pacel.pay',$row->id)}}"
                                                                    role="tab"
                                                                    aria-selected="false">Make Payments</a>
                                                            

                                                </td>
                                              
                                            </tr>
                                            @endforeach

                                            @endif

                                        </tbody>
                                    </table>
                                </div>
                                                    </div>




 
 <div class="modal-footer ">
 
         <button class="btn btn-link" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i> Close</button>
        </div>


     


    </div>
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
