    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="formModal">Debit Note Details  for {{$data->project_name}} -  {{$data->project_no}}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>


 <div class="modal-body">

<?php $total=0;?>

            <div class="table-responsive">
                                                            <table class="table datatable-modal table-striped" id="table-list">
                                       <thead>
                                            <tr>
                                           <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 26.484px;">#</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 126.484px;">Ref No</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 126.484px;">Purchase No</th>
                                                       <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 126.484px;">Supplier Name</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 126.484px;">Return Date</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;"> Amount</th>
                                            </tr>
                                        </thead>
                                         <tbody>
                                           @if(!empty($inv))
                                                                     @foreach ($inv as $row)
                                                                    <tr class="gradeA even" role="row">
                                                     <td>{{$loop->iteration}}</a>  </td>
                                                     <td>{{$row->reference_no}}</a>  </td>
                                                   <td> {{$row->purchase->reference_no }}</td>
                                                 <td>  {{$row->supplier->name }} </td>
                                                <td>{{Carbon\Carbon::parse($row->return_date)->format('d/m/Y')}}</td>
                       
                                                <td>{{number_format(($row->purchase_amount + $row->purchase_tax) * $row->exchange_rate ,2)}} TZS</td>
     
                                                                    </tr>
                                                                
                                                   <?php $total +=($row->purchase_amount + $row->purchase_tax) * $row->exchange_rate;?>
                                                                                @endforeach                                   
                                                                                @endif
                                            </tbody>

                                    <tfoot>
                                                                    <tr class="gradeA even" role="row">
                                                     <td>Total</a>  </td>
                                                     <td> </td>
                                                 <td </td>
                                                <td></td><td></td>
                                                <td><b>{{number_format($total,2)}} TZS</b></td>
     
                                                                    </tr>
                                                                
                                            </tfoot>
                                    </table>
                                </div>
                                                    </div>


        
        <div class="modal-footer">
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