    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="formModal"> {{$old->wbn_no }} Transmission Details</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    
        <div class="modal-body">

                                        <?php
                                          $total_cost=0;
                                                ?>

                                        <div class="table-responsive">
                                    <table class="table datatable-modal table-striped">
                                        <thead>
                                            <tr>                                              
                                              
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 20.484px;">#</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 150.484px;">Tracking ID</th>
                                                      <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 180.484px;">Category</th>
                                          <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 150.484px;">Duration</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Air Date</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 120.1094px;">Program</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!@empty($items))
                                            @foreach ($items as $row)
                                         
                                            <tr class="gradeA even" role="row">
                                                <td>{{$loop->iteration}}</td>
                                                 <td>{{$row->tracking_id}}</td>
                                          <td class="">{{$row->category}}</td>
                                             <td> {{$row->duration}}</td>                                             
                                            <td class="">{{Carbon\Carbon::parse($row->date)->format('d/m/Y')}} {{Carbon\Carbon::parse($row->air_time)->format('g:i A')}} </td>
                                             <td> {{$row->program}}</td>  
                                                 
                                                                                             
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

<script>
/*
             * Multiple drop down select
             */
            $('.m-b').select2({
                            });
</script>