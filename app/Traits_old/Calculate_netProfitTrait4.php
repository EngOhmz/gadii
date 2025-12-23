<?php
namespace App\Traits;

use App\Models\ClassAccount;
use \App\Models\JournalEntry;

trait Calculate_netProfitTrait4 {
    
public function get_netProfit4(){
$c=0;     
$sales_balance  = 0;
$sales_balance1  = 0;
$total_incomes  = 0;
$total_incomes1 = 0;
$total_other_incomes  = 0;
$total_other_incomes1 = 0;
$cost_balance  = 0;
$cost_balance1  = 0;
$total_cost  = 0;
$total_cost1  = 0;
$expense_balance  = 0;
$expense_balance1 = 0;
$total_expense  = 0;
$total_expense1  = 0;
$gross  = 0;
$gross1  = 0;
$profit=0;
$profit1=0;
$tax=0;
$tax1=0;
$net_profit=0;
$net_profit1=0;  
 
$total_debit_income_balance =0 ;
 $total_credit_income_balance  =0 ;
  $total_debit_other_income_balance   =0 ;
  $total_credit_other_income_balance  =0 ;
   $total_debit_cost_balance   =0 ;
   $total_credit_cost_balance  =0 ;
   $total_debit_expense_balance   =0 ;
   $total_credit_expense_balance  =0 ;
$gross_dr  = 0;
$gross_cr  = 0;
$tax_dr=0;
$tax_cr=0;
$profit_dr=0;
$profit_cr=0;   
$net_profit_dr=0;
$net_profit_cr=0;   

        
        //calculate unknown date
        
         //$datediff = strtotime($end_date) - strtotime($second_date);
         
         //$unknown_date  = strtotime($second_date) - $datediff;
         
         //$start_date = date('d - m - Y',$unknown_date);
        
           $income = ClassAccount::where('class_type','Income')->where('added_by',auth()->user()->added_by)->get();
           $cost = ClassAccount::where('class_type','Expense')->where('added_by',auth()->user()->added_by)->get();
           $expense= ClassAccount::where('class_type','Expense')->where('added_by',auth()->user()->added_by)->get();
           
           
foreach($income->where('added_by',auth()->user()->added_by) as $account_class){
foreach($account_class->groupAccount->where('added_by',auth()->user()->added_by)  as $group) {  
if($group->group_id != 5110){
foreach($group->accountCodes->where('added_by',auth()->user()->added_by) as $account_code){
     
     
                         $cr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('added_by',auth()->user()->added_by)->sum('debit');

                         $total_debit_income_balance   +=$dr ;
                         $total_credit_income_balance  +=$cr;

                          $income_balance=$dr- $cr;
                          $total_incomes+=$income_balance ;
                          
                


    }}}}           

foreach($income->where('added_by',auth()->user()->added_by) as $account_class){
foreach($account_class->groupAccount->where('added_by',auth()->user()->added_by)  as $group) {  
if($group->group_id == 5110){
foreach($group->accountCodes->where('added_by',auth()->user()->added_by) as $account_code){
   
                    $cr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('added_by',auth()->user()->added_by)->sum('debit');
                   
                        $total_debit_other_income_balance   +=$dr ;
                         $total_credit_other_income_balance  +=$cr;

                       $income_balance=$dr- $cr;
                          $total_other_incomes+=$income_balance ;
   

}}}} 



foreach($cost->where('added_by',auth()->user()->added_by) as $account_class){
foreach($account_class->groupAccount->where('added_by',auth()->user()->added_by)  as $group) {
if($group->group_id == 6180){
foreach($group->accountCodes->where('added_by',auth()->user()->added_by) as $account_code){


                   $cr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('added_by',auth()->user()->added_by)->sum('debit');
                            
                        $total_debit_cost_balance   +=$dr ;
                         $total_credit_cost_balance  +=$cr;

                        $cost_balance=$dr- $cr;
                        $total_cost+=$cost_balance ;
                            

}}}}


foreach($expense->where('added_by',auth()->user()->added_by) as $account_class){
foreach($account_class->groupAccount->where('added_by',auth()->user()->added_by)  as $group)  {      
if($group->group_id != 6180){
foreach($group->accountCodes->where('added_by',auth()->user()->added_by) as $account_code){

                   $cr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('added_by',auth()->user()->added_by)->sum('debit');
                            
                           $total_debit_expense_balance   +=$dr ;
                         $total_credit_expense_balance  +=$cr;

                $expense_balance=$dr- $cr;
                $total_expense+=$expense_balance ;
                          


}}}}


if($total_other_incomes < 0){
$total_o=$total_other_incomes * -1;
}
else if($total_other_incomes >= 0){
$total_o=$total_other_incomes ;
}







 if($total_incomes < 0){
$total_s= $total_incomes  * -1;
$gross_dr=$total_s+$total_o- $total_cost;
}
else if($total_incomes >= 0){
$gross_dr=$total_incomes+$total_o- $total_cost;
}



if($gross_dr < 0){
$profit_dr=$gross_dr+ $total_expense;
}
else if($gross_dr < 0 &&  $total_expense  < 0){
$profit_dr=$gross_dr+ $total_expense;
}
else if($gross_dr >= 0 && $total_expense < 0){
$profit_dr= $total_expense +$gross_dr;
}
else{
$profit_dr=$gross_dr-$total_expense;
}


  
if($profit_dr > 0){
$tax_dr=$profit_dr*0.3;
}


 $data['net_profit_dr'] =   $profit_dr-$tax_dr;

 

   
   
   
   
   return $data; 
   
   
   
   
   
   
   
   
   
   
    }
    
    
    
}