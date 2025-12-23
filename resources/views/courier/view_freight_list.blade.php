    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="formModal">Courier Freight List</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
      
        <div class="modal-body" id="modal_body">

                <?php   $amount=0; ?>

         <div class="table-responsive">
                                  <table class="table datatable-modal table-striped">
                                        <thead>
                                            <tr>

                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 30.484px;">#</th>
                                                   
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 106.484px;">Ref No</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 156.484px;">Route</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 156.219px;">Tariff</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Client</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 161.219px;">Amount</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!@empty($list))
                                            @foreach ($list as $row)
                                            <tr class="gradeA even" role="row">

                                                <td> {{$loop->iteration}}</td>
                                                <td>{{$row->confirmation_number}}</td>              
                                               <td>From {{$row->region_s->name}} to {{$row->region_e->name}}</td>
                                                <td>{{$row->route->zone_name}} - {{$row->route->weight}} </td>
                                                <td>{{$row->client->name}}</td>           
                                                <td>{{number_format($row->amount,2)}} {{$row->courier->currency_code}}</td>  
                                                
                                            </tr>
                                          <?php   $amount+=$row->amount; ?>
                                            @endforeach

                                            @endif

                                        </tbody>

                               <tfoot>
                                            <tr>

                                                <td></td>
                                                <td></td>              
                                               <td></td>
                                                <td> </td>
                                                <td></td>           
                                                <td>{{number_format($amount,2)}} TZS</td>  
                                                
                                            </tr>
                                         

                                        </tfoot>


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
                {"orderable": false, "targets": [3]}
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