    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="formModal"> {{$old->wbn_no }}  Quotation Details</h5>
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
                                                    style="width: 150.484px;">WBN</th>
                                                      <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 180.484px;">Route</th>
                                          <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 150.484px;">Tariff</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Total</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 120.1094px;">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!@empty($items))
                                            @foreach ($items as $row)
                                           <?php
                                               $pacel = App\Models\Courier\Courier::find($row->pacel_id);
                                                 $from=App\Models\Region::find($pacel->from_region_id);
                                                    $item_name = App\Models\Tariff::find($row->item_name);
                                                  ?>
                                            <tr class="gradeA even" role="row">
                                                <td>{{$loop->iteration}}</td>
                                                 <td>{{$row->wbn_no}}</td>
                                          <td class="">{{ $from->name }} -  @if(!empty($row->to->name)) {{ $row->to->name }} @endif</td>
                                             <td> @if(!empty($item_name)) {{$item_name->zone_name}} - {{$item_name->weight}}  @else {{$row->item_name }} @endif</td>                                             
                                            <td class="">{{number_format($row->total_cost + $row->total_tax ,2)}} </td>
                                                 <td>
                                               
                                                                              <div class="form-inline">
                           @if($row->start == 0)
                             <a  class="list-icons-item text-primary" title="Edit" onclick="return confirm('Are you sure?')"   href="{{ route('courier_quotation.edit', $row->id)}}"><i class="icon-pencil7"></i></a>&nbsp

 {!! Form::open(['route' => ['courier_quotation.destroy',$row->id], 'method' => 'delete']) !!}
<button type="submit" style="border:none;background: none; padding-top:20px;" class="list-icons-item text-danger" title="Delete" onclick="return confirm('Are you sure?')"><i class="icon-trash"></i></button>
{{ Form::close() }}
  
@endif                                                                                                              
 </div>
                                                 
                                                    </td>                                                
                                            </tr>

                                           <?php
                                          $total_cost+=$row->total_cost + $row->total_tax;
                                                ?>
                                            @endforeach
                                            @endif

                                        </tbody>


                                            <tfoot>
                                            <tr class="gradeA even" role="row">                                           
                                            <td class=""></td> <td class=""></td><td class=""></td>
                                        <td class="">Total </td>                                                    
                                            <td class="">{{number_format($total_cost ,2)}} </td>
                                                 <td></td>
                                                          
                                            </tr>

                                        </tfoot>
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