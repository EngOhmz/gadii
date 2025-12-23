
    <div class="modal-content">
        <div class="modal-header">
            <h2 class="modal-title" id="formModal" >School Fee Details</h2>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
       
<div class="modal-body">
<div class="row">

               <div class="table-responsive">
                    <table class="table datatable-modal table-striped" id="table-1">
                                        <thead>
                                            <tr>
                                                <th >#</th>
                                                <th>School Level</th>
                                                <th>Class</th>                                          
                                            </tr>
                                        </thead>
                                        <tbody>
                                           
                                       
                                            @if(!@empty($rows))
                                              @foreach ($rows as $row)
                                                <tr class="gradeA even" role="row">
                                                  <th>{{ $loop->iteration }}</th>
                                                   <td>{{$row->level}}</td>
                                                   <td>{{$row->class}}</td>
                                                              
                                      </tr>
                                    @endforeach                                
                                    @endif                                
                                   </tbody>                                       
                                    </table>
                </div>
            </div>

           
        </div>
        <div class="modal-footer bg-whitesmoke br">         
        <button class="btn btn-link" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i> Close</button>
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