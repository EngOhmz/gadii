
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="formModal" >Payment Details For {{$data->student->student_name}} in the year {{$data->year}}</h5>
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
                                                    <th>Reference</th> 
                                                <th>Fee Type</th>
                                                <th>Months</th> 
                                            <th>Amount</th> 
                                                  <th>Payment Account</th> 
                                            <th>Payment Date</th>                                          
                                            </tr>
                                        </thead>
                                        <tbody>
                                           
                                       
                                            @if(!@empty($payment))
                                              @foreach ($payment as $row)
                                                <tr class="gradeA even" role="row">
                                                  <th>{{ $loop->iteration }}</th>
                                                   <td>{{$row->reference}}</td>
                                                   <td>{{$row->type}}</td>
                                                      <td>
                                             @if($row->type == 'Transport Fees')
                                             {{$row->start_month}} -  {{$row->end_month}} {{$row->year}}
                                             @elseif($row->type == 'Hostel Fees')
                                             {{$row->start_month}} -  {{$row->end_month}} {{$row->year}}
                                             @elseif($row->duration == '1')
                                              {{$row->start_month}} {{$row->year}}
                                            @else
                                              January - November {{$row->year}} 
                                              @endif
                                        </td>     
                                             <td>{{number_format($row->paid,2)}} </td>     
                                              <td>@if(!empty($row->bank_id)){{$row->chart->account_name}}@endif</td>
                                                   <td>{{Carbon\Carbon::parse($row->date)->format('M d, Y')}}</td>             
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
                {"orderable": false, "targets": [0]}
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