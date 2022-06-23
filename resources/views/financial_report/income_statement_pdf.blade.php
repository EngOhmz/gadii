<style>
    table {
        width: 100%;
        border-collapse: collapse;
        font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    }
    th, td {
        padding: 10px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }
    th {
        background-color: #4CAF50;
        color: white;
    }
</style>
<div>

   @if(!empty($start_date))
              <table class="table col-lg-6">
                      <caption>
                {{trans_choice('general.income',1)}} {{trans_choice('general.sheet',1)}}
              @if(!empty($start_date))
                    for period: <b>{{$start_date}} to {{$second_date}}</b>
                @endif
            </caption>
                    <thead>
                    <tr class="bg-green">
                        <th>{{trans_choice('general.account',1)}}</th>
                        <th>{{trans_choice('general.balance',1)}}</th>
                    </tr>
                    </thead>
                      <tbody>
                    <tr>
                        <td colspan="2" style="text-align: left"><b>{{trans_choice('general.sale',1)}}</b></td>
                    </tr>
                                 <?php
                     $c=0;     
                    $sales_balance  = 0;
                    $total_sales  = 0;
                    $cost_balance  = 0;
                    $total_cost  = 0;
                    $expense_balance  = 0;
                    $total_expense  = 0;
                    $gross  = 0;
                   $profit=0;
                  $tax=0;
                $net_profit=0;
?>            
     
     @foreach($sales as $account_class)
  @foreach($account_class->groupAccount  as $group)                             
@foreach($group->accountCodes as $account_code)
<tr>
 <td>{{$account_code->account_name }}</td>
 <?php
                   
                        $cr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$start_date, $end_date])->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$start_date, $end_date])->where('branch_id',
                            session('branch_id'))->sum('debit');

                       $sales_balance=$dr- $cr;
                          $total_sales+=$sales_balance ;
                        ?>                           
                             <td>{{ number_format(abs($sales_balance),2) }}</td>

                        </tr>
                                                                
 @endforeach              
  @endforeach
  @endforeach
 
           <tr>
                        <td >
                            <b>{{trans_choice('general.total',1)}} {{trans_choice('general.sale',2)}}</b></td>
                          <td><b>{{ number_format(abs($total_sales),2) }}</b></td>
                    </tr> 

 <tr>
                        <td colspan="2" style="text-align: left"><b>{{trans_choice('general.cogs',1)}}</b></td>
                    </tr>
  @foreach($cost as $account_class)
  @foreach($account_class->groupAccount  as $group)                             
@foreach($group->accountCodes as $account_code)
<tr>
 <td>{{$account_code->account_name }}</td>
 <?php
                   
                        $cr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$start_date, $end_date])->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$start_date, $end_date])->where('branch_id',
                            session('branch_id'))->sum('debit');

                       $cost_balance=$dr- $cr;
                          $total_cost+=$cost_balance ;
                        ?>                           
                             <td>{{ number_format(abs($cost_balance),2) }}</td>

                        </tr>
                                                                
 @endforeach              
  @endforeach
  @endforeach

   
           <tr>
                        <td >
                            <b>{{trans_choice('general.total',1)}} {{trans_choice('general.cogs',2)}}</b></td>
                          <td><b>{{ number_format(abs($total_cost),2) }}</b></td>
                    </tr> 
      <tr>
                        <td >
                            <b>{{trans_choice('general.gross',2)}}</b></td>

                     
                       <?php
if($total_sales < 0){
$total_s=$total_sales * -1;
$gross=$total_s-$total_cost;
}
else if($total_sales > 0){
$gross=$total_sales-$total_cost;
}
?>
                     
                 <td><b>{{ number_format($gross,2) }}</b></td>
                    </tr> 
                    <tr>
                        <td colspan="2" style="text-align: left"><b>{{trans_choice('general.expense',2)}}</b></td>
                    </tr>

                  @foreach($expense as $account_class)
  @foreach($account_class->groupAccount  as $group)                             
@foreach($group->accountCodes as $account_code)
<tr>
 <td>{{$account_code->account_name }}</td>
 <?php
                   
                        $cr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$start_date, $end_date])->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$start_date, $end_date])->where('branch_id',
                            session('branch_id'))->sum('debit');

                       $expense_balance=$dr- $cr;
                          $total_expense+=$expense_balance ;
                        ?>                           
                             <td>{{ number_format(abs($expense_balance),2) }}</td>

                        </tr>
                                                               
 @endforeach              
  @endforeach
  @endforeach

   
           <tr>
                        <td >
                            <b>{{trans_choice('general.total',1)}} {{trans_choice('general.expense',2)}}</b></td>
                          <td><b>{{ number_format($total_expense,2) }}</b></td>
                    </tr> 
                    </tbody>
                    <tfoot>
                    <tr>
                        <td>
                            <b>{{trans_choice('general.income_profit',2)}}</b></td>
                        <?php

if($gross < 0){
$profit=$gross+$total_expense;
}
else if($gross < 0 && $total_expense < 0){
$profit=$gross+$total_expense;
}
else{
$profit=$gross-$total_expense;
}
?>
                        <td><b>{{ number_format($profit,2) }}</b></td>
                    </tr>
                     <tr>
                        <td>
                            <b>{{trans_choice('general.tax',1)}}</b></td>
                               <?php
if($profit > 0){
$tax=$profit*0.3;
}
?>
                        <td><b>{{ number_format($tax,2) }}</b></td>
                    </tr>
                     <tr>
                        <td>
                            <b> {{trans_choice('general.income_profit',1)}}</b></td>
                        <td><b>{{ number_format($profit-$tax,2) }}</b></td>
                    </tr>
                    </tfoot>
                </table>
        

       @else
 <table class="table col-lg-6">
                      <caption>
                {{trans_choice('general.income',1)}} {{trans_choice('general.sheet',1)}}
         
            </caption>
                    <thead>
                    <tr class="bg-green">
                        <th>{{trans_choice('general.account',1)}}</th>
                        <th>{{trans_choice('general.balance',1)}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td colspan="2" style="text-align: left"><b>{{trans_choice('general.sale',1)}}</b></td>
                    </tr>
                                 <?php
                     $c=0;     
                    $sales_balance  = 0;
                    $total_sales  = 0;
                    $cost_balance  = 0;
                    $total_cost  = 0;
                    $expense_balance  = 0;
                    $total_expense  = 0;
                    $gross  = 0;
                   $profit=0;
                  $tax=0;
                $net_profit=0;
?>            
     
     @foreach($sales as $account_class)
  @foreach($account_class->groupAccount  as $group)                             
@foreach($group->accountCodes as $account_code)
<tr>
 <td>{{$account_code->account_name }}</td>
 <?php
                   
                        $cr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('branch_id',
                            session('branch_id'))->sum('debit');

                       $sales_balance=$dr- $cr;
                          $total_sales+=$sales_balance ;
                        ?>                           
                             <td>{{ number_format(abs($sales_balance),2) }}</td>

                        </tr>
                                                                
 @endforeach              
  @endforeach
  @endforeach
 
           <tr>
                        <td >
                            <b>{{trans_choice('general.total',1)}} {{trans_choice('general.sale',2)}}</b></td>
                          <td><b>{{ number_format(abs($total_sales),2) }}</b></td>
                    </tr> 

 <tr>
                        <td colspan="2" style="text-align: left"><b>{{trans_choice('general.cogs',1)}}</b></td>
                    </tr>
  @foreach($cost as $account_class)
  @foreach($account_class->groupAccount  as $group)                             
@foreach($group->accountCodes as $account_code)
<tr>
 <td>{{$account_code->account_name }}</td>
 <?php
                   
                        $cr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('branch_id',
                            session('branch_id'))->sum('debit');

                       $cost_balance=$dr- $cr;
                          $total_cost+=$cost_balance ;
                        ?>                           
                             <td>{{ number_format(abs($cost_balance),2) }}</td>

                        </tr>
                                                                
 @endforeach              
  @endforeach
  @endforeach

   
           <tr>
                        <td >
                            <b>{{trans_choice('general.total',1)}} {{trans_choice('general.cogs',2)}}</b></td>
                          <td><b>{{ number_format(abs($total_cost),2) }}</b></td>
                    </tr> 
      <tr>
                        <td >
                            <b>{{trans_choice('general.gross',2)}}</b></td>

                     
                       <?php
if($total_sales < 0){
$total_s=$total_sales * -1;
$gross=$total_s-$total_cost;
}
else if($total_sales > 0){
$gross=$total_sales-$total_cost;
}
?>
                     
                 <td><b>{{ number_format($gross,2) }}</b></td>
                    </tr> 
                    <tr>
                        <td colspan="2" style="text-align: left"><b>{{trans_choice('general.expense',2)}}</b></td>
                    </tr>

                  @foreach($expense as $account_class)
  @foreach($account_class->groupAccount  as $group)                             
@foreach($group->accountCodes as $account_code)
<tr>
 <td>{{$account_code->account_name }}</td>
 <?php
                   
                        $cr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('branch_id',
                            session('branch_id'))->sum('debit');

                       $expense_balance=$dr- $cr;
                          $total_expense+=$expense_balance ;
                        ?>                           
                             <td>{{ number_format(abs($expense_balance),2) }}</td>

                        </tr>
                                                               
 @endforeach              
  @endforeach
  @endforeach

   
           <tr>
                        <td >
                            <b>{{trans_choice('general.total',1)}} {{trans_choice('general.expense',2)}}</b></td>
                          <td><b>{{ number_format($total_expense,2) }}</b></td>
                    </tr> 
                    </tbody>
                    <tfoot>
                    <tr>
                        <td>
                            <b>{{trans_choice('general.income_profit',2)}}</b></td>
                        <?php

if($gross < 0){
$profit=$gross+$total_expense;
}
else if($gross < 0 && $total_expense < 0){
$profit=$gross+$total_expense;
}
else{
$profit=$gross-$total_expense;
}
?>
                        <td><b>{{ number_format($profit,2) }}</b></td>
                    </tr>
                     <tr>
                        <td>
                            <b>{{trans_choice('general.tax',1)}}</b></td>
                               <?php
if($profit > 0){
$tax=$profit*0.3;
}
?>
                        <td><b>{{ number_format($tax,2) }}</b></td>
                    </tr>
                     <tr>
                        <td>
                            <b> {{trans_choice('general.income_profit',1)}}</b></td>
                        <td><b>{{ number_format($profit-$tax,2) }}</b></td>
                    </tr>
                    </tfoot>
                </table>
            </div>
    @endif



 @if(!empty($end_date))
              <table class="table col-lg-6">
                   <caption>
                {{trans_choice('general.income',1)}} {{trans_choice('general.sheet',1)}}
              @if(!empty($end_date))
                      for period: <b>{{$second_date}} to {{$end_date}}</b>
                @endif
            </caption>
                    <thead>
                    <tr class="">
                        <th>{{trans_choice('general.balance',1)}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td><b>{{trans_choice('general.sale',1)}}</b></td>
                    </tr>
                                 <?php
                     $c=0;     
                    $sales_balance  = 0;
                    $total_sales  = 0;
                    $cost_balance  = 0;
                    $total_cost  = 0;
                    $expense_balance  = 0;
                    $total_expense  = 0;
                    $gross  = 0;
                   $profit=0;
                  $tax=0;
                $net_profit=0;
?>            
     
     @foreach($sales as $account_class)
  @foreach($account_class->groupAccount  as $group)                             
@foreach($group->accountCodes as $account_code)
<tr>

 <?php
                   
                        $cr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$second_date, $end_date])->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$second_date, $end_date])->where('branch_id',
                            session('branch_id'))->sum('debit');

                       $sales_balance=$dr- $cr;
                          $total_sales+=$sales_balance ;
                        ?>                           
                             <td>{{ number_format(abs($sales_balance),2) }}</td>

                        </tr>
                                                                
 @endforeach              
  @endforeach
  @endforeach
 
           <tr>

                          <td><b>{{ number_format(abs($total_sales),2) }}</b></td>
                    </tr> 

 <tr>
                        <td ><b>{{trans_choice('general.cogs',1)}}</b></td>
                    </tr>
  @foreach($cost as $account_class)
  @foreach($account_class->groupAccount  as $group)                             
@foreach($group->accountCodes as $account_code)
<tr>

 <?php
                   
                        $cr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$second_date, $end_date])->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$second_date, $end_date])->where('branch_id',
                            session('branch_id'))->sum('debit');

                       $cost_balance=$dr- $cr;
                          $total_cost+=$cost_balance ;
                        ?>                           
                             <td>{{ number_format(abs($cost_balance),2) }}</td>

                        </tr>
                                                                
 @endforeach              
  @endforeach
  @endforeach

   
           <tr>

                          <td><b>{{ number_format(abs($total_cost),2) }}</b></td>
                    </tr> 
      <tr>
                       
                     
                       <?php
if($total_sales < 0){
$total_s=$total_sales * -1;
$gross=$total_s-$total_cost;
}
else if($total_sales > 0){
$gross=$total_sales-$total_cost;
}
?>
                     
                 <td><b>{{ number_format($gross,2) }}</b></td>
                    </tr> 
                    <tr>
                        <td ><b>{{trans_choice('general.expense',2)}}</b></td>
                    </tr>

                  @foreach($expense as $account_class)
  @foreach($account_class->groupAccount  as $group)                             
@foreach($group->accountCodes as $account_code)
<tr>
 <?php
                   
                        $cr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$second_date, $end_date])->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$second_date, $end_date])->where('branch_id',
                            session('branch_id'))->sum('debit');

                       $expense_balance=$dr- $cr;
                          $total_expense+=$expense_balance ;
                        ?>                           
                             <td>{{ number_format(abs($expense_balance),2) }}</td>

                        </tr>
                                                               
 @endforeach              
  @endforeach
  @endforeach

   
           <tr>

                          <td><b>{{ number_format($total_expense,2) }}</b></td>
                    </tr> 
                    </tbody>
                    <tfoot>
                    <tr>
                        <?php

if($gross < 0){
$profit=$gross+$total_expense;
}
else if($gross < 0 && $total_expense < 0){
$profit=$gross+$total_expense;
}
else{
$profit=$gross-$total_expense;
}
?>
                        <td><b>{{ number_format($profit,2) }}</b></td>
                    </tr>
                     <tr>
                               <?php
if($profit > 0){
$tax=$profit*0.3;
}
?>
                        <td><b>{{ number_format($tax,2) }}</b></td>
                    </tr>
                     <tr>
                        <td><b>{{ number_format($profit-$tax,2) }}</b></td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>

       @else


             <table class="table col-lg-6">
                   <caption>
                {{trans_choice('general.income',1)}} {{trans_choice('general.sheet',1)}}
            
            </caption>
                    <thead>
                    <tr class="">
                        <th>{{trans_choice('general.balance',1)}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td><b>{{trans_choice('general.sale',1)}}</b></td>
                    </tr>
                                 <?php
                     $c=0;     
                    $sales_balance  = 0;
                    $total_sales  = 0;
                    $cost_balance  = 0;
                    $total_cost  = 0;
                    $expense_balance  = 0;
                    $total_expense  = 0;
                    $gross  = 0;
                   $profit=0;
                  $tax=0;
                $net_profit=0;
?>            
     
     @foreach($sales as $account_class)
  @foreach($account_class->groupAccount  as $group)                             
@foreach($group->accountCodes as $account_code)
<tr>

 <?php
                   
                        $cr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('branch_id',
                            session('branch_id'))->sum('debit');

                       $sales_balance=$dr- $cr;
                          $total_sales+=$sales_balance ;
                        ?>                           
                             <td>{{ number_format(abs($sales_balance),2) }}</td>

                        </tr>
                                                                
 @endforeach              
  @endforeach
  @endforeach
 
           <tr>

                          <td><b>{{ number_format(abs($total_sales),2) }}</b></td>
                    </tr> 

 <tr>
                        <td ><b>{{trans_choice('general.cogs',1)}}</b></td>
                    </tr>
  @foreach($cost as $account_class)
  @foreach($account_class->groupAccount  as $group)                             
@foreach($group->accountCodes as $account_code)
<tr>

 <?php
                   
                        $cr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('branch_id',
                            session('branch_id'))->sum('debit');

                       $cost_balance=$dr- $cr;
                          $total_cost+=$cost_balance ;
                        ?>                           
                             <td>{{ number_format(abs($cost_balance),2) }}</td>

                        </tr>
                                                                
 @endforeach              
  @endforeach
  @endforeach

   
           <tr>

                          <td><b>{{ number_format(abs($total_cost),2) }}</b></td>
                    </tr> 
      <tr>
                       
                     
                       <?php
if($total_sales < 0){
$total_s=$total_sales * -1;
$gross=$total_s-$total_cost;
}
else if($total_sales > 0){
$gross=$total_sales-$total_cost;
}
?>
                     
                 <td><b>{{ number_format($gross,2) }}</b></td>
                    </tr> 
                    <tr>
                        <td ><b>{{trans_choice('general.expense',2)}}</b></td>
                    </tr>

                  @foreach($expense as $account_class)
  @foreach($account_class->groupAccount  as $group)                             
@foreach($group->accountCodes as $account_code)
<tr>
 <?php
                   
                        $cr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('branch_id',
                            session('branch_id'))->sum('debit');

                       $expense_balance=$dr- $cr;
                          $total_expense+=$expense_balance ;
                        ?>                           
                             <td>{{ number_format(abs($expense_balance),2) }}</td>

                        </tr>
                                                               
 @endforeach              
  @endforeach
  @endforeach

   
           <tr>

                          <td><b>{{ number_format($total_expense,2) }}</b></td>
                    </tr> 
                    </tbody>
                    <tfoot>
                    <tr>
                        <?php

if($gross < 0){
$profit=$gross+$total_expense;
}
else if($gross < 0 && $total_expense < 0){
$profit=$gross+$total_expense;
}
else{
$profit=$gross-$total_expense;
}
?>
                        <td><b>{{ number_format($profit,2) }}</b></td>
                    </tr>
                     <tr>
                               <?php
if($profit > 0){
$tax=$profit*0.3;
}
?>
                        <td><b>{{ number_format($tax,2) }}</b></td>
                    </tr>
                     <tr>
                        <td><b>{{ number_format($profit-$tax,2) }}</b></td>
                    </tr>
                    </tfoot>
                </table>
          
    @endif

</div>