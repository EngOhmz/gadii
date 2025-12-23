
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="formModal">
@if($type=='mechanical_maintainance')
Maintainance
@else
Service 
@endif 
Mechanical Report </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    
        <div class="modal-body">
            <p><strong>Make sure you enter valid information</strong> .</p>
                     
           

                                            <br>
                                            <div class="table-responsive">
                                                
                                            <table class="table datatable-b table-striped" id="service">
                                                <thead>
                                                    <tr>
                                                    <th>#</th>
                                                        <th>Service Type</th>
                                                       
                                                    </tr>
                                                </thead>
                                                <tbody >
                                                @foreach ($item as $row)
                                              <tr class="gradeA even" role="row">
                                                <td>{{ $loop->iteration }}</td>
                                                 <td>{{ $row->service->name }}</td>
                                             </tr>
                                            @endforeach
                                                </tbody>
                                               

                                            </table>

                                    
<br>
                               <table class="table datatable-modal table-striped" id="recommedation">
                                                <thead>
                                                    <tr>
                                                   <th>#</th>
                                                        <th>Recommedation</th>
                                                        
                                                    </tr>
                                                </thead>
                                                <tbody >
                                               @foreach ($notes as $row)
                                              <tr class="gradeA even" role="row">
                                                <td>{{ $loop->iteration }}</td>
                                                 <td>{{ $row->recommedation }}</td>
                                             </tr>
                                            @endforeach

                                                </tbody>
                                               

                                            </table>
</div>
                                                  
                                                             
                                                            

        </div>
       <div class="modal-footer ">
         <button class="btn btn-link" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i> Close</button>
        </div>
        {!! Form::close() !!}
    </div>
</div>


@yield('scripts')

 <script>
        $('.datatable-b').DataTable({
            autoWidth: false,
            "columnDefs": [{
                "targets": [0]
            }],
            dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
            "language": {
                search: '<span>Filter:</span> _INPUT_',
                searchPlaceholder: 'Type to filter...',
                lengthMenu: '<span>Show:</span> _MENU_',
                paginate: {
                    'first': 'First',
                    'last': 'Last',
                    'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;',
                    'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;'
                }
            },

        });
    </script>
    
    <script>
        $('.datatable-modal').DataTable({
            autoWidth: false,
            "columnDefs": [{
                "targets": [0]
            }],
            dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
            "language": {
                search: '<span>Filter:</span> _INPUT_',
                searchPlaceholder: 'Type to filter...',
                lengthMenu: '<span>Show:</span> _MENU_',
                paginate: {
                    'first': 'First',
                    'last': 'Last',
                    'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;',
                    'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;'
                }
            },

        });
    </script>