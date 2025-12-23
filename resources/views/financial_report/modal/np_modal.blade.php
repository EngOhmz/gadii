<div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"  style="text-align:center;"> {{$account_code->account_codes }} - {{$account_code->account_name }}<h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>


        <div class="modal-body">
  <div class="table-responsive">
                            <table class="table datatable-eq table-striped">
       
                      
<thead>
                    <tr>
                   <th>Account Name</th>
                        <th>Account Code</th>
                          <th>Balance</th>
         
                    </tr>
                    </thead>
                              <tbody>
 <tr>
                        <td colspan="3" style="text-align: left"><b>Income</b></td>
                    </tr>

  <?php   
$total_incomes_start   = 0;
$total_other_incomes_start   = 0;
$cost_balance_start   = 0;
$total_cost_start   = 0;
$expense_balance_start   = 0;
$total_expense_start   = 0;
$gross_start   = 0;
$profit_start =0;
$tax_start =0;
$net_profit_start =0;
$total_debit_income_balance_start  =0 ;
 $total_credit_income_balance_start   =0 ;
  $total_debit_other_income_balance_start    =0 ;
  $total_credit_other_income_balance_start   =0 ;
   $total_debit_cost_balance_start    =0 ;
   $total_credit_cost_balance_start   =0 ;
   $total_debit_expense_balance_start    =0 ;
   $total_credit_expense_balance_start   =0 ;
$gross_dr_start   = 0;
$gross_cr_start   = 0;
$tax_dr_start =0;
$tax_cr_start =0;
$profit_dr_start =0;
$profit_cr_start =0;   
$net_profit_dr_start =0;
$net_profit_cr_start =0;   

foreach($income->where('added_by',auth()->user()->added_by) as $account_class_modal){
foreach($account_class_modal->groupAccount->where('added_by',auth()->user()->added_by)  as $group_modal) {  
if($group_modal->group_id != 5110){
foreach($group_modal->accountCodes->where('added_by',auth()->user()->added_by) as $account_code_modal){
     
     
                          if(!empty($branch_id) && $branch_id != $a){
                        $cr_start  = \App\Models\JournalEntry::where('account_id', $account_code_modal->id)->whereIn('branch_id', $br_id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr_start = \App\Models\JournalEntry::where('account_id', $account_code_modal->id)->whereIn('branch_id', $br_id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('debit');
                            
                         }else{
                            
                             $cr_start  = \App\Models\JournalEntry::where('account_id', $account_code_modal->id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr_start  = \App\Models\JournalEntry::where('account_id', $account_code_modal->id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('debit');
                            
                            }

                         $total_debit_income_balance_start  +=$dr_start  ;
                         $total_credit_income_balance_start  +=$cr_start ;

                          $income_balance_start =$dr_start - $cr_start ;
                          $total_incomes_start +=$income_balance_start  ;
                          ?>
<tr>
  <td>{{$account_code_modal->account_name }}</td>
<td>{{$account_code_modal->account_codes }}</td>
  <td>{{ number_format(abs($income_balance_start),2) }}</td>
</tr>                
  <?php  

    }}}}           
?>

<tr>
                        <td >
                            <b>Total Income</b></td>
                       <td></td>
                            <td>{{ number_format(abs($total_incomes_start),2) }}</td>                           
                    </tr> 
<!--
 
                        <td colspan="3" style="text-align: left"><b> Financial Cost</b></td>
                    </tr>
  <?php  
foreach($cost->where('added_by',auth()->user()->added_by) as $account_class_modal){
foreach($account_class_modal->groupAccount->where('added_by',auth()->user()->added_by)  as $group_modal) {
if($group_modal->group_id == 6180){
foreach($group_modal->accountCodes->where('added_by',auth()->user()->added_by) as $account_code_modal){


                    if(!empty($branch_id) && $branch_id != $a){
                        $cr_start  = \App\Models\JournalEntry::where('account_id', $account_code_modal->id)->whereIn('branch_id', $br_id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr_start = \App\Models\JournalEntry::where('account_id', $account_code_modal->id)->whereIn('branch_id', $br_id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('debit');
                            
                         }else{
                            
                             $cr_start  = \App\Models\JournalEntry::where('account_id', $account_code_modal->id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr_start  = \App\Models\JournalEntry::where('account_id', $account_code_modal->id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('debit');
                            
                            }
                            
                        $total_debit_cost_balance_start    +=$dr_start  ;
                         $total_credit_cost_balance_start   +=$cr_start ;

                        $cost_balance_start =$dr_start - $cr_start ;
                        $total_cost_start +=$cost_balance_start  ;

  ?>
<tr>
  <td>{{$account_code_modal->account_name }}</td>
<td>{{$account_code_modal->account_codes }}</td>
  <td>{{ number_format(abs($cost_balance_start),2) }}</td>
</tr>                
  <?php  

                            
}}}}
?>

<tr>
                        <td >
                             <b>Total Financial Cost</b></td>
                       <td></td>
      <td>{{ number_format(abs($total_cost_start),2) }}</td>
                    </tr> 
-->

  <?php  

if($total_other_incomes_start < 0){
$total_o_start=$total_other_incomes_start * -1;
}
else if($total_other_incomes_start >= 0){
$total_o_start=$total_other_incomes_start ;
}


if($total_incomes_start < 0){
$total_s_start=$total_incomes_start * -1;
$gross_start=$total_s_start+$total_o_start-$total_cost_start;
}
else if($total_incomes_start >= 0){
$gross_start=$total_incomes_start+$total_o_start-$total_cost_start;
}



?>
<!--
  <tr>
                        <td >
                            <b>Gross Profit</b></td>
                    <td></td>
                            <td><b>{{ number_format($gross_start ,2) }}</b></td>
                    </tr> 
-->

<tr>
                        <td colspan="3" style="text-align: left"><b>Expenses</b></td>
                    </tr>
  <?php  
foreach($expense->where('added_by',auth()->user()->added_by) as $account_class_modal){
foreach($account_class_modal->groupAccount->where('added_by',auth()->user()->added_by)  as $group_modal)  {      
if($group_modal->group_id != 6180){
foreach($group_modal->accountCodes->where('added_by',auth()->user()->added_by) as $account_code_modal){

                   if(!empty($branch_id) && $branch_id != $a){
                        $cr_start  = \App\Models\JournalEntry::where('account_id', $account_code_modal->id)->whereIn('branch_id', $br_id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr_start = \App\Models\JournalEntry::where('account_id', $account_code_modal->id)->whereIn('branch_id', $br_id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('debit');
                            
                         }else{
                            
                             $cr_start  = \App\Models\JournalEntry::where('account_id', $account_code_modal->id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr_start  = \App\Models\JournalEntry::where('account_id', $account_code_modal->id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('debit');
                            
                            }

                            
                           $total_debit_expense_balance_start    +=$dr_start  ;
                         $total_credit_expense_balance_start   +=$cr_start ;

                $expense_balance_start =$dr_start - $cr_start ;
                $total_expense_start +=$expense_balance_start  ;
                          
  ?>
  <tr>
  <td>{{$account_code_modal->account_name }}</td>
<td>{{$account_code_modal->account_codes }}</td>
  <td>{{ number_format(abs($expense_balance_start ),2) }}</td>
       </tr>             
  <?php  

}}}}

?>

<tr>
                        <td >
                             <b>Total Expenses</b></td>
                       <td></td>
                               <td>{{ number_format($total_expense_start ,2) }}</td>
                    </tr> 

  <?php  

if($gross_start  < 0){
$profit_start =$gross_start + $total_expense_start ;
}
else if($gross_start  < 0 &&  $total_expense_start   < 0){
$profit_start =$gross_start + $total_expense_start ;
}
else if($gross_start  >= 0 &&  $total_expense_start   < 0){
$profit_start = $total_expense_start  +$gross_start ;
}
else{
$profit_start =$gross_start -$total_expense_start ;
}


if($profit_start > 0){
$tax_start =$profit_start *0.3;
}

?>

<tr>
                        <td>
                           <b>Profit Before Tax</b></td>
                            <td></td>
                                 <td><b>{{ number_format($profit_start ,2) }}</b></td>
                    </tr>
                     <tr>
                        <td>
                            <b>Tax</b></td>
                         <td></td>
                              <td><b>{{ number_format($tax_start ,2) }}</b></td>
                    </tr>
                   
<tr>
                      <td colspan=2>
                           <b>{{$account_code->account_name }} Total Balance</b></td>
                        <td colspan=2><b>{{ number_format($profit_start-$tax_start,2) }}</b></td>
                    </tr>


   
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
    
    
    