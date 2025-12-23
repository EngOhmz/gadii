<!DOCTYPE html>
<html>

<style type="text/css">
    body{
        font-family: 'Roboto Condensed', sans-serif;
    }
    .m-0{
        margin: 0px;
    }
    .p-0{
        padding: 0px;
    }
    .pt-5{
        padding-top:5px;
    }
    .mt-10{
        margin-top:10px;
    }
 .mt-20{
        margin-top:50px;
    }
    .text-center{
        text-align:center !important;
    }
    .w-100{
        width: 100%;
    }
   
    .w-85{
        width:85%;   
    }
    .w-15{
        width:15%;   
    }
    .logo img{
        width:45px;
        height:45px;
        padding-top:30px;
    }
    .logo span{
        margin-left:8px;
        top:19px;
        position: absolute;
        font-weight: bold;
        font-size:25px;
    }
    .gray-color{
        color:#5D5D5D;
    }
    .text-bold{
        font-weight: bold;
    }
    .border{
        border:1px solid black;
    }
    table tbody tr, table thead th, table tbody td{
        border: 1px solid #d2d2d2;
        border-collapse:collapse;
        padding:7px 8px;
    }
    table tr th{
        background-color: #2F75B5;
      color:white;
        font-size:15px;
    }
    table tr td{
        font-size:13px;
    }
    table{
        border-collapse:collapse;
    }
table tbody tr:nth-of-type(odd) {
    background-color: rgba(0,0,0,.07);
}
table tbody tr {
    background-color: #ffffff;
}
    .box-text p{
        line-height:10px;
    }
    .float-left{
        float:left;
    }
    .total-part{
        font-size:16px;
        line-height:12px;
    }
    .total-right p{
        padding-right:30px;
    }
footer {
            color: #777777;
            width: 100%;
            height: 30px;
            position: absolute;
            bottom: -20px;
            border-top: 1px solid #aaaaaa;
            padding: 8px 0;
            text-align: center;
        }

        table tfoot tr:first-child td {
            border-top: none;
        }
 table tfoot tr td {
  padding:7px 8px;
        }


        table tfoot tr td:first-child {
            border: none;
        }

</style>
<body>
 <?php
$settings= App\Models\System::first();

?>
<div class="add-detail ">
   <table class="table w-100 ">
<tfoot>
       
        <tr>
            <td class="w-50">
                <div class="box-text">
                    <center><img class="pl-lg" style="width: 133px;height:120px;" src="{{url('public/assets/img/logo')}}/{{$settings->picture}}">  </center>
                </div>
            </td>
  
                  
        </tr>
</tfoot>
    </table>


    <div style="clear: both;"></div>
</div>

<div class="table-section bill-tbl w-100 mt-10">
    <table class="table w-100 mt-10">
<tfoot>
 <td class="w-50">
                <div class="box-text">
                    <center><b> INCOME STATEMENT FOR THE PERIOD BETWEEN 
                     {{Carbon\Carbon::parse($start_date)->format('d/m/Y')}} to {{Carbon\Carbon::parse($end_date)->format('d/m/Y')}} </b> </center>
                </div>
        <td>
         
        </tr>

</tfoot>
    </table>

</div>

    @if(!empty($start_date))
<div class="table-section bill-tbl w-100 mt-10">
      <table class="table w-100 mt-10">
                    
                     <tbody>
                    <tr>
                        <td colspan="6" style="text-align: left"><b>Income</b></td>
                    </tr>
                                 <?php
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
?>            
     
     @foreach($income->where('added_by',auth()->user()->added_by) as $account_class)
  @foreach($account_class->groupAccount->where('added_by',auth()->user()->added_by)  as $group)   
@foreach($group->accountCodes->where('added_by',auth()->user()->added_by) as $account_code)
<tr>
  <td>{{$account_code->account_name }}</td>
<td>{{$account_code->account_codes }}
 
</td>
 <?php
                   
                        $cr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$start_date, $end_date])->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                              [$start_date, $end_date])->sum('debit');
                            
                        
                            
                            
                        //   $cr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('branch_id',
                        //     session('branch_id'))->sum('credit');
                        // $dr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('branch_id',
                        //     session('branch_id'))->sum('debit');
                            
                        //   $cr1 = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('branch_id',
                        //     session('branch_id'))->sum('credit');
                        // $dr1 = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('branch_id',
                        //     session('branch_id'))->sum('debit');

                       $income_balance=$dr- $cr;
                          $total_incomes+=$income_balance ;
                          

                        ?>                          
                             <td colspan="4">{{ number_format(abs($income_balance),2) }}</td>

                             

                        </tr>
                                                                
 @endforeach 
  @endforeach
  @endforeach
 
           <tr>
                        <td >
                            <b>Total Income</b></td>
                           <td colspan="5" style="text-align: right"><b>{{ number_format(abs($total_incomes),2) }}</b></td>
                           
                         
                    </tr> 
                    
            
  <!--   
 <tr>
                        <td colspan="4" style="text-align: left"><b>Financial Cost</b></td>
                    </tr>
  @foreach($cost->where('added_by',auth()->user()->added_by) as $account_class)
  @foreach($account_class->groupAccount->where('added_by',auth()->user()->added_by)  as $group) 
  @if($group->group_id == 6180)
@foreach($group->accountCodes->where('added_by',auth()->user()->added_by) as $account_code)
<tr>
 <td>{{$account_code->account_name }}</td>
<td><a href="#view{{$account_code->account_id}}" data-toggle="modal">{{$account_code->account_codes }}</a>

</td>
 <?php
                   
                        $cr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$start_date, $end_date])->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$start_date,$end_date])->sum('debit');


                            
                       $cost_balance=$dr- $cr;
                        
                          $total_cost+=$cost_balance ;
                        ?>                        
                             <td>{{ number_format(abs($cost_balance),2) }}</td>
                            

                        </tr>
                                                                
 @endforeach  
 @endif
  @endforeach
  
  @endforeach

   
           <tr>
                        <td >
                            <b>Total Financial Cost</b></td>
                          <td colspan="5" style="text-align: right"><b>{{ number_format(abs($total_cost),2) }}</b></td>
                      
                    </tr> 
      <tr>
                        <td >
                            <b>Gross Profit</b></td>


                     
                <td colspan="5" style="text-align: right"><b>{{ number_format($gross,2) }}</b></td>
                    </tr> 
                 
  -->

                     
                       <?php

if($total_other_incomes < 0){
$total_o=$total_other_incomes * -1;
}
else if($total_other_incomes >= 0){
$total_o=$total_other_incomes ;
}




if($total_incomes < 0){
$total_s=$total_incomes * -1;
$gross=$total_s+$total_o-$total_cost;
}
else if($total_incomes >= 0){
$gross=$total_incomes+$total_o-$total_cost;
}


?>
                    
                       <tr>
                        <td colspan="6" style="text-align: left"><b>Expenses</b></td>
                    </tr>



                  @foreach($expense->where('added_by',auth()->user()->added_by) as $account_class)
  @foreach($account_class->groupAccount->where('added_by',auth()->user()->added_by)  as $group)        
    @if($group->group_id != 6180)
@foreach($group->accountCodes->where('added_by',auth()->user()->added_by) as $account_code)
<tr>
 <td>{{$account_code->account_name }}</td>
<td>{{$account_code->account_codes }}
  
</td>
 <?php
                   
                        $cr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$start_date, $end_date])->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$start_date, $end_date])->where('added_by',auth()->user()->added_by)->sum('debit');
                            
                        

                       $expense_balance=$dr- $cr;
                          $total_expense+=$expense_balance ;
                          
                        ?>                           
                             <td colspan="4">{{ number_format(abs($expense_balance),2) }}</td>
                       
                        </tr>
                                                               
 @endforeach  
 @endif
  @endforeach
  @endforeach

   
           <tr>
                        <td >
                            <b>Total Expenses</b></td>
                           <td colspan="5" style="text-align: right"><b>{{ number_format($total_expense,2) }}</b></td>
                    </tr> 
                    </tbody>
                    <tfoot>
                    <tr>
                        <td>
                           <b>Profit Before Tax</b></td>
                        <?php

if($gross < 0){
$profit=$gross+$total_expense;
}
else if($gross < 0 && $total_expense < 0){
$profit=$gross+$total_expense;
}
else if($gross >= 0 && $total_expense < 0){
$profit=$total_expense +$gross;
}
else{
$profit=$gross-$total_expense;
}


?>
                         <td colspan="5" style="text-align: right"><b>{{ number_format($profit,2) }}</b></td>
                    </tr>
                     <tr>
                        <td>
                            <b>Tax</b></td>
                               <?php
if($profit > 0){
$tax=$profit*0.3;
}


?>
                        <td colspan="5" style="text-align: right"><b>{{ number_format($tax,2) }}</b></td>
                    </tr>
                     <tr>
                        <td>
                            <b>Net Profit</b></td>
                        <td colspan="5" style="text-align: right"><b>{{ number_format($profit-$tax,2) }}</b></td>
                    </tr>
                    </tfoot>
               
                    
                </table>
</div>
    @endif

</body>
</html>