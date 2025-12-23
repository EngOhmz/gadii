<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="formModal">Permit Type List </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
     
        <div class="modal-body">
            <div class="table-responsive">
                                    <table class="table datatable-modal table-striped " id="table-4">
                                        <thead>
                                            <tr>
                                         <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 56.484px;">#</th> 
                                                     <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 126.484px;">Type</th>                                             
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 126.484px;">Value</th>
                                                    
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!@empty($type))
                                            @foreach ($type as $row)
                                            <tr class="gradeA even" role="row">
                                                 <td>{{ $loop->iteration }}</td>
                                               <td>{{$row->type}}</td>
                                                <td>{{number_format($row->value,2)}}</td>
                                                    </tr>
                                             @endforeach
                                             @endif
                                        </tbody>
                                        <tfoot>
                                          <tr >
                                              <td></td> <td><b>Total</b></td>
                                                <td><b>{{number_format($total,2)}}</b></td>
                                                    </tr>
                                       <tfoot>
                                    </table>
                                </div>

   
                

        </div>
        <div class="modal-footer bg-whitesmoke br">
           
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
       
    </div>
</div>


@yield('scripts')
<script>
       $('.datatable-modal').DataTable({
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