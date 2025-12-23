    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="formModal">
Location Manager - {{$data->name}} </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    
        <div class="modal-body">
                     
                                            <div class="table-responsive">
                                                
                                            <table class="table datatable-modal table-striped" id="service">
                                                <thead>
                                                    <tr>
                                                    <th>#</th>
                                                        <th>Manager</th>
                                                       
                                                    </tr>
                                                </thead>
                                                <tbody >
                                                @foreach ($item as $row)
                                              <tr class="gradeA even" role="row">
                                                <td>{{ $loop->iteration }}</td>
                                                 <td>{{ $row->user->name }}</td>
                                             </tr>
                                            @endforeach
                                                </tbody>
                                               

                                            </table>

                                            
        </div>

       <div class="modal-footer ">
         <button class="btn btn-link" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i> Close</button>
        </div>
       
    </div>



@yield('scripts')
<script>
       $('.datatable-modal').DataTable({
            autoWidth: false,
            "columnDefs": [
                {"targets": [1]}
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