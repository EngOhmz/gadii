<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="formModal">
Assigned User for Project {{$data->project_name}} - {{$data->project_no}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    <div class="modal-body">

                                
<br>

<div class="table-responsive">
<table class="table datatable-modal table-striped">
    <thead>
        <tr role="row">

            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                rowspan="1" colspan="1"
                aria-label="Browser: activate to sort column ascending"
                style="width: 28.531px;">#</th>
            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                rowspan="1" colspan="1"
                aria-label="Platform(s): activate to sort column ascending"
                style="width: 106.484px;">Name</th>
          
           
        </tr>
    </thead>
    <tbody>
        @if(!@empty($user))
        @foreach ($user as $row)
        <tr class="gradeA even" role="row">
            <td>{{ $loop->iteration }}</td>
            <td> {{$row->assign->name}}</td>
                          
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