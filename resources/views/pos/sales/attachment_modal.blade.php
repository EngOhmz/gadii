   
                                            
                                           
                                            
                                             @if (!@empty($images[0]))
                                            <div class="table-responsive">
                                        <table class="table datatable-modal table-striped">
                                            <thead>
                                                <tr>

                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Platform(s): activate to sort column ascending"
                                                        style="width:36.484px;">#</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Platform(s): activate to sort column ascending"
                                                        style="width: 176.484px;">File</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="CSS grade: activate to sort column ascending"
                                                        style="width: 108.1094px;">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (!@empty($images))
                                                    @foreach ($images as $row)
                                                        @php $ext=pathinfo($row->filename, PATHINFO_EXTENSION);; @endphp

                                                        <tr class="gradeA even" role="row">

                                                            <td>{{$loop->iteration}}</td>
                                                            <td>{{--<img src="https://pro.alchemdigital.com/api/extension-image/{{$ext}}"/> --}} {{ $row->original_filename }}</td>

                                                            

                                                            <td>
                                                                <div class="form-inline">
                                        <a class="list-icons-item text-primary" title="Download" href="{{ route('download_attachment', $row->id) }}">Download</a>&nbsp &nbsp
                                    <a class="list-icons-item text-danger" title="Delete"  onclick="return confirm('Are you sure?')" href="{{ route('delete_attachment', $row->id) }}">Delete</a>&nbsp &nbsp

                                                                </div>
                                                            </td>

                                                        </tr>
                                                    @endforeach

                                                @endif

                                            </tbody>
                                        </table>
                                           </div> 
                                           
                                            
                                            <hr>
                                            @endif
                                            
                                            
                                            
                                            
        
        
        @yield('scripts')
        
        
        <script>
        $('.datatable-modal').DataTable({
            autoWidth: false,
            "columnDefs": [{
                "orderable": false,
                "targets": [1]
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
    
      
    
   
   