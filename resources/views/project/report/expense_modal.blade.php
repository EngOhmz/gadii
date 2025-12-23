    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="formModal">Expenses Details  for {{$data->project_name}} -  {{$data->project_no}}</h5>
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
                                                    aria-label="Browser: activate to sort column ascending"
                                                    style="width: 98.531px;">#</th>

                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 106.484px;">Reference</th>
                                               
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 146.484px;">Expense Account</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Payment Account</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Amount</th>
                                                      <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Date</th>
                                            </tr>
                                        </thead>
                                         <tbody>
                                           @if(!empty($inv))
                                                                     @foreach ($inv as $row)
                                                                    <tr class="gradeA even" role="row">
                                                     <td>{{$loop->iteration}}</a>  </td>
                                                  <td>{{$row->name}}</td>

                                                    @php
                                                 $account=App\Models\AccountCodes::where('id',$row->account_id)->first();
                                                @endphp
                                               @if(!empty($account))
                                                <td>{{$account->account_name}}</td>
                                              @else
                                                <td></td>
                                              @endif

                                                      @php
                                                 $bank=App\Models\AccountCodes::where('id',$row->bank_id)->first();
                                                @endphp
                                                <td>{{$bank->account_name}}</td>

                                                   <td>{{number_format($row->amount,2)}} TZS</td>

                                                       <td>{{Carbon\Carbon::parse($row->date)->format('d/m/Y')}}</td>
     
                                                                    </tr>
                                                                
                                                   <?php $total +=$row->amount;?>
                                                                                @endforeach                                   
                                                                                @endif
                                            </tbody>

                                    <tfoot>
                                                                    <tr class="gradeA even" role="row">
                                                     <td>Total</a>  </td>
                                                     <td> </td>
                                                 <td </td>
                                                <td></td><td><b>{{number_format($total,2)}} TZS</b></td>
                                                <td></td>
     
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