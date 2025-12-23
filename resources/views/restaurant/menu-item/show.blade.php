<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="formModal">Menu Component for {{$menu->name}} </h5>
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
                                    style="width: 26.484px;">#</th>
                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                    rowspan="1" colspan="1"
                                    aria-label="Platform(s): activate to sort column ascending"
                                    style="width: 186.484px;">Menu Component</th>
                                  
                            </tr>
                        </thead>
                        <tbody>
                            @if(!@empty($items))
                            @foreach ($items as $row)
                            <tr class="gradeA even" role="row">

                                <td>
                                    {{ $loop->iteration }}
                                </td>
                                <td>{{$row->name}}</td>
        
                            </tr>
                            @endforeach

                            @endif

                        </tbody>
                    </table>
            </div>                                        

        </div>
        <div class="modal-footer bg-whitesmoke br">
 
            <button class="btn btn-link" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i> Close</button>
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