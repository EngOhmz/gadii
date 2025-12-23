<div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"  style="text-align:center;"> {{$account_class->class_name }}<h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>


           <?php    
$unit_dr  = 0;
$unit_cr  = 0;
$total_cr= 0;
$total_dr= 0;
$total_v= 0;
$cr_in = 0;
$dr_in = 0;                   
$cr_out  = 0;
$dr_out  = 0;
$total_vat=0;
$total_out=0;
$total_in=0;
?> 


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
  @foreach($account_class->groupAccount->where('added_by',auth()->user()->added_by)  as $group)
@foreach($group->accountCodes->where('added_by',auth()->user()->added_by) as $account_code)
   @if($account_code->account_name == 'Value Added Tax (VAT)')      
  <tr>
                        <td >{{ $account_code->account_codes }}</td>
                          <td >{{ $account_code->account_name }}</td>
                          
                        
                   <?php
                   
                         $vat_in= \App\Models\AccountCodes::where('account_name', 'VAT IN')->where('added_by',auth()->user()->added_by)->first();
                        $vat_out= \App\Models\AccountCodes::where('account_name', 'VAT OUT')->where('added_by',auth()->user()->added_by)->first();

                        if(!empty($branch_id) && $branch_id != $a){
                       $cr_in = \App\Models\JournalEntry::where('account_id', $vat_in->id)->whereIn('branch_id', $br_id)->where('date', '<=',$start_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr_in = \App\Models\JournalEntry::where('account_id', $vat_in->id)->whereIn('branch_id', $br_id)->where('date', '<=',$start_date)->where('added_by',auth()->user()->added_by)->sum('debit'); 

                        $cr_out = \App\Models\JournalEntry::where('account_id',  $vat_out->id)->whereIn('branch_id', $br_id)->where('date', '<=',$start_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr_out = \App\Models\JournalEntry::where('account_id', $vat_out->id)->whereIn('branch_id', $br_id)->where('date', '<=',$start_date)->where('added_by',auth()->user()->added_by)->sum('debit');
                            
                         }else{
                            $cr_in = \App\Models\JournalEntry::where('account_id', $vat_in->id)->where('date', '<=',$start_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr_in = \App\Models\JournalEntry::where('account_id', $vat_in->id)->where('date', '<=',$start_date)->where('added_by',auth()->user()->added_by)->sum('debit'); 

                        $cr_out = \App\Models\JournalEntry::where('account_id',  $vat_out->id)->where('date', '<=',$start_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr_out = \App\Models\JournalEntry::where('account_id', $vat_out->id)->where('date', '<=',$start_date)->where('added_by',auth()->user()->added_by)->sum('debit');
                            
                            }
                            

                         $total_in= $dr_in- $cr_in ;
                          $total_out = $cr_out - $dr_out ;
                      
                       if ($total_in - $total_out < 0){
                        $total_vat_cr=($total_in -  $total_out) * -1;
                         $total_v=($total_in -  $total_out) * -1;
                       }
                       else{
                         $total_vat_dr=$total_in -  $total_out;
                           $total_v=($total_in -  $total_out) * -1;; 
                         }

     
                   $total_cr = $total_cr + $total_v;
                                      

                   ?>
                     
                         @if ($total_in - $total_out < 0)
                                   <td>{{ number_format(0 ,2) }} </td>
                                        <td>{{ number_format(abs(($total_in - $total_out) *-1 ),2) }}  </td>
                                
                           @else
                                 <td>{{ number_format(abs($total_in - $total_out ),2) }}  </td>
                                <td>{{ number_format(0 ,2) }} </td>

                           @endif 
                    </tr> 

                
 @elseif($account_code->account_name != 'Deffered Tax' && $account_code->account_name != 'Value Added Tax (VAT)' && $account_code->account_codes != '31101')


 <?php   

  if(!empty($branch_id) && $branch_id != $a){
                        
                            
                         if ($account_class->class_type == 'Assets' || $account_class->class_type == 'Liability' || $account_class->class_type == 'Equity'){
                        $cr = \App\Models\JournalEntry::where('account_id', $account_code->id)->whereIn('branch_id', $br_id)->where('date', '<=',$start_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->id)->whereIn('branch_id', $br_id)->where('date', '<=',$start_date)->where('added_by',auth()->user()->added_by)->sum('debit');
                        }
                        else{
                         $cr = \App\Models\JournalEntry::where('account_id', $account_code->id)->whereIn('branch_id', $br_id)->whereBetween('date',[$start_date, $start_date])->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->id)->whereIn('branch_id', $br_id)->whereBetween('date',[$start_date, $start_date])->where('added_by',auth()->user()->added_by)->sum('debit');
                        }
                            
                          }
                          else{
                              
                                
                         if ($account_class->class_type == 'Assets' || $account_class->class_type == 'Liability' || $account_class->class_type == 'Equity'){
                        $cr = \App\Models\JournalEntry::where('account_id', $account_code->id)->where('date', '<=',$start_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->id)->where('date', '<=',$start_date)->where('added_by',auth()->user()->added_by)->sum('debit');
                        }
                        else{
                         $cr = \App\Models\JournalEntry::where('account_id', $account_code->id)->whereBetween('date',[$start_date, $start_date])->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->id)->whereBetween('date',[$start_date, $start_date])->where('added_by',auth()->user()->added_by)->sum('debit');
                        }
                            
                          }   

                       $unit_cr +=($cr-$dr);
                       $unit_dr +=($dr-$cr);
                         $total_dr += $dr ;
                         $total_cr  += $cr ;  
  ?>
  <tr>
                        <td >{{ $account_code->account_codes }}</td>
                          <td >{{ $account_code->account_name }}</td>
                           @if ($account_class->class_type == 'Assets' || $account_class->class_type == 'Expense')
                                           <td>{{ number_format($dr-$cr ,2) }}  </td>
                                 <td>{{ number_format(0 ,2) }} </td>
                           @else
                                <td>{{ number_format(0 ,2) }} </td>
                            <td>{{ number_format($cr-$dr ,2) }}  </td> 
                           @endif
                        
                 
                    </tr> 
                    
                    
@elseif($account_code->account_name == 'Deffered Tax')


 <?php   

  if(!empty($branch_id) && $branch_id != $a){
                        $cr = \App\Models\JournalEntry::where('account_id', $account_code->id)->whereIn('branch_id', $br_id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->id)->whereIn('branch_id', $br_id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('debit');
                            
                         }else{
                            
                            $cr = \App\Models\JournalEntry::where('account_id', $account_code->id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('debit');
                            
                            }

                       $unit_cr +=($cr-$dr) + $net_profit['tax_for_second_date'];
                       $unit_dr +=0;
                         $total_dr += 0 ;
                         $total_cr  += ($cr-$dr) + $net_profit['tax_for_second_date']; ;  
  ?>
  <tr>
                        <td >{{ $account_code->account_codes }}</td>
                          <td >{{ $account_code->account_name }}</td>
                            <td>{{ number_format(0,2) }}</td>
                            <td>{{ number_format(($cr+$net_profit['tax_for_second_date']) - $dr,2) }}</td>
                           
                        
                 
                    </tr> 


@elseif($account_code->account_codes  == 31101) 


 <?php   

 

                       $unit_cr +=$net_profit['profit_for_second_date'];
                       $unit_dr +=0;
                         $total_dr += 0 ;
                         $total_cr  += $net_profit['profit_for_second_date'] ;  
  ?>
  <tr>
                        <td >{{ $account_code->account_codes }}</td>
                          <td >{{ $account_code->account_name }}</td>
                            <td>{{ number_format(0,2) }}</td>
                            <td>{{ number_format($net_profit['profit_for_second_date'],2) }}</td>
                           
                        
                 
                    </tr> 

                         
                       
@endif
            @endforeach
@endforeach          
                        </tbody>
<tfoot>
<tr>     
                     
                          <td></td>
                             <td><b> Total Balance</b></td>
                              @if ($account_class->class_type == 'Assets' || $account_class->class_type == 'Expense')
                                           <td>{{ number_format( $unit_dr ,2) }}  </td>
                                 <td>{{ number_format(0 ,2) }} </td>
                           @else
                                <td>{{ number_format(0 ,2) }} </td>
                            <td>{{ number_format( $unit_cr + $total_v ,2) }}  </td> 
                           @endif
                         
                          
                    </tr> 
 <tr>     
                        <td >
                             <b>{{$account_class->class_name }} Total Balance</b></td>
                              @if ($account_class->class_type == 'Assets' || $account_class->class_type == 'Expense')
                            <td colspan="3"><b>{{ number_format($total_dr -  $total_cr,2) }}</b></td>
                           @else
                                 <td colspan="3"><b>{{ number_format($total_cr -  $total_dr,2) }}</b></td>
                           @endif
                            
                    </tr>
<tfoot>
      
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
    
    
    