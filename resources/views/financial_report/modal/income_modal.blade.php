<div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"  style="text-align:center;"> Income<h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>


        <div class="modal-body">
  <div class="table-responsive">
                             <table class="table datatable-basic table-striped">
<thead>
                    <tr>
                       <th>Account Code</th>
                          <th>Account Name</th>
                            <th>Debit</th>
                        <th>Credit</th>
                    </tr>
                    </thead>
 <tbody>   
 
 @foreach($income as $account_class)
 
<?php    
 $unit_total  = 0;
   $total_cr= 0;
$total_dr= 0;
?> 
 
                @foreach($account_class->groupAccount->where('added_by',auth()->user()->added_by)  as $group)                             
@foreach($group->accountCodes->where('added_by',auth()->user()->added_by) as $account_code) 
                    <?php                   
                         if(!empty($branch_id) && $branch_id != $a){
                        $cr = \App\Models\JournalEntry::where('account_id', $account_code->id)->whereIn('branch_id', $br_id)->whereBetween('date',[$start_date, $second_date])->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->id)->whereIn('branch_id', $br_id)->whereBetween('date',
                            [$start_date, $second_date])->where('added_by',auth()->user()->added_by)->sum('debit');
                            
                         }else{
                            
                             $cr = \App\Models\JournalEntry::where('account_id', $account_code->id)->whereBetween('date',[$start_date, $second_date])->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->id)->whereBetween('date',
                            [$start_date, $second_date])->where('added_by',auth()->user()->added_by)->sum('debit');
                            
                            }

                          $unit_total  +=($cr-$dr);
                              $total_cr+=$cr;
                           $total_dr+=$dr;
                        ?>  
                                 
                                <tr>
                        <td >{{ $account_code->account_codes }}</td>
                          <td >{{ $account_code->account_name }}</td>
                          <td>{{ number_format($dr ,2) }}</td>
                   <td >{{ number_format($cr ,2) }}</td>
                    </tr> 

           
  @endforeach
 @endforeach  
  @endforeach 
                              </tbody>
<tfoot>
<tr>     
                      
                        <td></td>
                            <td><b>Total</b></td>
                             <td><b>{{ number_format($total_dr,2) }}</b></td>
                            <td><b>{{ number_format($total_cr,2) }}</b></td>
 
                    </tr> 

<tr>
                        <td >
                               <b>Income Total Balance</b></td>
                           <td colspan="3"><b>{{ number_format( $unit_total ,2) }}</b></td>

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
    
    
    