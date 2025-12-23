<div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"  style="text-align:center;"> {{$account_code->account_codes }} - {{$account_code->account_name }}<h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>


        <div class="modal-body">
  <div class="table-responsive">
                             <table class="table datatable-basic table-striped">
<thead>
                    <tr>
                       <th>Date</th>
                            <th>Debit</th>
                        <th>Credit</th>
                      <th>Note</th>
                    </tr>
                    </thead>
 <tbody>   
 <?php
 
                          if(!empty($branch_id)){
                        $account = \App\Models\JournalEntry::where('account_id', $account_code->id)->whereIn('branch_id', $br_id)->whereBetween('date',
                            [$start_date, $end_date])->where('added_by',auth()->user()->added_by)->orderBy('date','desc')->get();
                            
                       
                            
                          }
                          else{
                              
                             $account = \App\Models\JournalEntry::where('account_id', $account_code->id)->where('added_by',auth()->user()->added_by)->whereBetween('date',
                            [$start_date, $end_date])->orderBy('date','desc')->get();
                            
                          }
                          
                          
                        ?>  
                 @foreach($account->where('added_by',auth()->user()->added_by)  as $a)
                                 <tr>
                        <td >{{Carbon\Carbon::parse($a->date)->format('d/m/Y')}}</td>
                          <td>{{ number_format($a->debit ,2) }}</td>
                   <td >{{ number_format($a->credit ,2) }}</td>
                       <td >{{ $a->notes }}</td>
                    </tr> 

                @endforeach
                
        </tbody>    
    
 <?php
                   
                    if(!empty($branch_id)){
                         $cr_modal = \App\Models\JournalEntry::where('account_id', $account_code->id)->whereIn('branch_id', $br_id)->whereBetween('date',
                            [$start_date, $end_date])->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr_modal = \App\Models\JournalEntry::where('account_id', $account_code->id)->whereIn('branch_id', $br_id)->whereBetween('date',
                            [$start_date, $end_date])->where('added_by',auth()->user()->added_by)->sum('debit');
                            
                        
                            
                          }
                          else{
                              
                              $cr_modal = \App\Models\JournalEntry::where('account_id', $account_code->id)->whereBetween('date',
                            [$start_date, $end_date])->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr_modal = \App\Models\JournalEntry::where('account_id', $account_code->id)->whereBetween('date',
                            [$start_date, $end_date])->where('added_by',auth()->user()->added_by)->sum('debit');
                            
                         
                          }
                          
                      

                        ?> 
                        <tfoot>
                    <tr>     
                        <td><b>Total</b></td>
                           <td><b>{{ number_format($dr_modal,2) }}</b></td>
                            <td><b>{{ number_format($cr_modal,2) }}</b></td>
                             <td></td>
                             
                    </tr> 
  <tr>
                        <td>
                              <b>{{$account_code->account_name }} Total Balance</b></td>                           
                            @if ($account_code->type == 'Assets' || $account_code->type == 'Expense')
     <td colspan="3"><b>{{ number_format($dr_modal-$cr_modal ,2) }} </b></td>                                
                           @else
                         <td colspan="3"><b>{{ number_format($cr_modal-$dr_modal ,2) }} </b></td>
                           @endif 
                       

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
       $('.datatable-basic').DataTable({
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
    
    
    