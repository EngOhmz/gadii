
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="formModal">Tyre list</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
     
        <div class="modal-body">
           
                                            <div class="table-responsive">
                                                
                                            <table class="table datatable-modal table-striped"  id="service">
                                                <thead>
                                                    <tr>
                                                      <th>#</th>
                                                        <th>Tyre</th>
                                                          <th>Tyre Position</th>
                                                       
                                                    </tr>
                                                </thead>
                                                <tbody >
                                              
            
 @if(!@empty($tyre))
                                            @foreach ($tyre as $row)
                                            <tr class="gradeA even" role="row">
                                                <th>{{ $loop->iteration }}</th>
                                                <td>{{$row->tyre->serial_no }}</td>
                                                <td>{{$row->position}}</td>
                                               
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
        {!! Form::close() !!}
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
