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
$settings= App\Models\System::where('added_by',auth()->user()->added_by)->first();

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
                    <center><b> BALANCE SHEET AS AT
                     {{Carbon\Carbon::parse($start_date)->format('d/m/Y')}} </b> </center>
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
                        <td colspan="4" style="text-align: center"><b>Assets</b></td>
                    </tr>


               <?php
               $c=0;     
                    $total_liabilities = 0;
                    $total_debit_assets = 0;
                    $total_credit_assets = 0;
                      $total_debit_liability  = 0;
                    $total_credit_liability  = 0;
                        $total_debit_equity  = 0;
                    $total_credit_equity  = 0;
                   $total_assets = 0;
                    $total_equity = 0;
                    
                 
?>            
     
     @foreach($asset->where('added_by',auth()->user()->added_by) as $account_class)
<?php    $c++ ; 

 $unit_total1   = 0;
 $unit_total2   = 0;

?>
                          <tr>
                        <td >{{ $c }} . </td>
                        <td ><b>{{ $account_class->class_name  }}</b></td>
                  <td ></td>
                  <td ></td>
               
                    </tr>

  
               
  @foreach($account_class->groupAccount->where('added_by',auth()->user()->added_by)  as $group)
                             
@foreach($group->accountCodes->where('added_by',auth()->user()->added_by) as $account_code)
<tr>
 <td></td>
 <td>{{$account_code->account_name }}</td>
​<td>{{$account_code->account_codes }}
</td>
 <?php
                   
                        $cr1 = \App\Models\JournalEntry::where('account_id', $account_code->id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr1 = \App\Models\JournalEntry::where('account_id', $account_code->id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('debit');


                         $total_credit_assets +=($dr1-$cr1);
                         
                         $unit_total1  +=($dr1-$cr1);
                        ?>                           
                            <td>{{ number_format($dr1-$cr1,2) }}</td>
                        </tr>
             
                                 
                  
 @endforeach              
  @endforeach
               
                      

                 
  
  @endforeach
                      
 
           <tr>
                        <td colspan="3" style="text-align: right">
                            <b>Total Assets</b></td>
                        <td><b>{{ number_format($total_credit_assets,2) }}</b></td>

                    </tr>            
                   
     
                      
                       

                    
                    <tr>
                        <td colspan="4" style="text-align: center "><b>Liabilities</b></td> <!-- sehemu ya liabilitty==================================================== -->
                    </tr>
                     @foreach($liability->where('added_by',auth()->user()->added_by)  as $account_class)
<?php    $c++ ; 

 $unit_total1  =0;
 $unit_total2  =0;

?>
                          <tr>
                        <td >{{ $c }} . </td>
                        <td ><b>{{ $account_class->class_name  }}</b></td>
                  <td colspan="2"></td>
                    </tr>

  
               
  @foreach($account_class->groupAccount->where('added_by',auth()->user()->added_by)  as $group)
                             
@foreach($group->accountCodes->where('added_by',auth()->user()->added_by) as $account_code)
@if($account_code->account_name == 'Value Added Tax (VAT)')
<tr>
 <td></td>
 <td>{{$account_code->account_name }}</td>
 <td>{{$account_code->account_codes }}</a>

</td>
<?php
                        $cr_in = 0;
                        $dr_in = 0;                   
                        $cr_out  = 0;
                        $dr_out  = 0;
                        $total_vat=0;
                           $total_out=0;
                             $total_in=0;
                             
                      
                        $vat_in= \App\Models\AccountCodes::where('account_name', 'VAT IN')->where('added_by',auth()->user()->added_by)->first();
                        $vat_out= \App\Models\AccountCodes::where('account_name', 'VAT OUT')->where('added_by',auth()->user()->added_by)->first();

                        $cr_in = \App\Models\JournalEntry::where('account_id', $vat_in->account_id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr_in = \App\Models\JournalEntry::where('account_id', $vat_in->account_id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('debit'); 

                        $cr_out = \App\Models\JournalEntry::where('account_id',  $vat_out->account_id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr_out = \App\Models\JournalEntry::where('account_id', $vat_out->account_id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('debit');
                            

                         $total_in= $dr_in- $cr_in ;
                          $total_out = $cr_out - $dr_out ;
                         if ($total_in - $total_out < 0){
                        $total_vat=($total_in -  $total_out) * -1;
                       }
                       else{
                         $total_vat=($total_in -  $total_out) * -1;;
                         }
                   $unit_total2  =$unit_total2+$total_vat ; ; ;
                         
  ?>
                          

                                        <td>{{ number_format($total_vat,2) }}  </td>
                                
                          
                        
</tr>

@else
<tr>
 <td></td>
 <td>{{$account_code->account_name }}</td>
​<td>{{$account_code->account_codes }}</a>
</td>
 <?php
                   
                            
                        $cr1 = \App\Models\JournalEntry::where('account_id', $account_code->id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr1 = \App\Models\JournalEntry::where('account_id', $account_code->id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('debit');

                      if($account_code->account_name == 'Deffered Tax'){
                       $total_credit_liability  =    $total_credit_liability + $net_profit['tax_for_second_date'];
                                              
                         $unit_total2  +=($cr1-$dr1) +  $net_profit['tax_for_second_date'];

                         }
                         else{
                          
                         $total_credit_liability  +=($cr1-$dr1);                     
                         
                         $unit_total2  +=($cr1-$dr1)  ;
                           }

                       
                        ?>                           
                              @if($account_code->account_name != 'Deffered Tax')
                                                 
                            <td>{{ number_format($cr1-$dr1,2) }}</td>
                         </tr>
                       
                         @else
                             
                            <td>{{ number_format($net_profit['tax_for_second_date'],2) }}</td>
                        </tr>
                         @endif

                    
             
                                 
  @endif                  
 @endforeach              ​
 ​@endforeach

 ​@endforeach


  ​<tr>
                       ​<td colspan="3" style="text-align: right">
                           ​<b>Total Liabilities</b></td>
                       ​<td><b>{{ number_format($total_credit_liability + $total_vat,2) }}</b></td>

                   ​</tr>  
<tr>
                        <td colspan="4" style="text-align: center"><b>Equities</b></td>   <!-- //sehemu ya equity ==================================================================== -->
                    </tr>
    @foreach($equity->where('added_by',auth()->user()->added_by)   as $account_class)
<?php    $c++ ; 
  
     $unit_cost  = 0;
     $unit_cost1 = 0;

?>
                          <tr>
                        <td >{{ $c }} . </td>
                        <td ><b>{{ $account_class->class_name  }}</b></td>
                  <td colspan="2"></td>
                    </tr>

  
               
  @foreach($account_class->groupAccount->where('added_by',auth()->user()->added_by)  as $group)
                             
@foreach($group->accountCodes->where('added_by',auth()->user()->added_by) as $account_code)
<tr>
 <td></td>
 <td>{{$account_code->account_name }}</td>
​<td>{{$account_code->account_codes }}
</td>
 <?php
                   
                            
                            
                        $cr1 = \App\Models\JournalEntry::where('account_id', $account_code->id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr1 = \App\Models\JournalEntry::where('account_id', $account_code->id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('debit');
                     
                     
                         if($account_code->account_codes == 31101){
                         $total_credit_equity    =$total_credit_equity + $net_profit['profit_for_second_date'];
                         $unit_cost1 = $unit_cost1 + $net_profit['profit_for_second_date'];  
                          
                        //   $unit_cost =1000 ;
                        //  $unit_cost1 = 1000;
                         }else{
                         $total_credit_equity    +=($cr1-$dr1) ;
                         $unit_cost1 +=($cr1-$dr1);
                         } ?>
                         @if($account_code->account_codes != 31101)
                                                 
                            <td>{{ number_format($cr1-$dr1,2) }}</td>
                       
                       
                         @else
                             
                            <td>{{ number_format($net_profit['profit_for_second_date'],2) }}</td>
                        </tr>
                         @endif
                                 
                  
 @endforeach              ​
 ​@endforeach
               
 ​@endforeach
                   
                                      <tr>
                        <td colspan="3" style="text-align: right">
                            <b>Total Equities</b></td>
                       ​<td><b>{{ number_format($total_credit_equity,2) }}</b></td>
                    </tr>

                  <tr>
                        <td colspan="3" style="text-align: right">
                            <b>Total Liabilities And Equities</b>
                        </td>


                        <td><b>{{ number_format($total_credit_liability+$total_credit_equity + $total_vat,2) }}</b></td>
                    </tr>
                    </tbody>
                   
               
                    
                </table>
</div>
    @endif

</body>
</html>