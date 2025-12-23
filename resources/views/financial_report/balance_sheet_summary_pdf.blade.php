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
                    <center><b> BALANCE SHEET SUMMARY AS AT
                     {{Carbon\Carbon::parse($start_date)->format('d/m/Y')}} </b> </center>
                </div>
        <td>
         
        </tr>

</tfoot>
    </table>

</div>

    @if(!empty($start_date))
    
       @if(isset($branch_id))
     @php
       $a=  trim(json_encode($x), '[]'); 
     if($branch_id == $a){
         $br_id=$x;
     }
     
     else{
         
      $br_id=$z;    
     }
     
     @endphp
     @endif
     
<div class="table-section bill-tbl w-100 mt-10">
      <table class="table w-100 mt-10">
                    
      <tbody>
                    <tr>
                        <td colspan="4" style="text-align: center"><b>Assets</b></td>
                   

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

?>
                        
  
               
  @foreach($account_class->groupAccount->where('added_by',auth()->user()->added_by)->where('disabled','0')  as $group)
                             
@foreach($group->accountCodes->where('added_by',auth()->user()->added_by)->where('disabled','0') as $account_code)

 @php
     $account_id=$account_code->id;
      $amount=App\Traits\Calculate_Balance::get_amount($start_date,$branch_id,$account_id);
     
     @endphp

 <?php
 

                         $total_credit_assets +=($amount['debit']);

                        ?>                           
                         
             
                                 
                  
 @endforeach              
  @endforeach

  @endforeach
                      

                        <td><b>{{ number_format($total_credit_assets,2) }}</b></td>

                    </tr>            
                   
     
                      
                       

                    
                    <tr>
                        <td colspan="4" style="text-align: center "><b>Liabilities</b></td> <!-- sehemu ya liabilitty==================================================== -->
                  
                     @foreach($liability->where('added_by',auth()->user()->added_by)  as $account_class)
<?php    $c++ ; 

?>
                        
  @foreach($account_class->groupAccount->where('added_by',auth()->user()->added_by)->where('disabled','0')  as $group)
                             
@foreach($group->accountCodes->where('added_by',auth()->user()->added_by)->where('disabled','0') as $account_code)

 @php
     $account_id=$account_code->id;
      $amount=App\Traits\Calculate_Balance::get_amount($start_date,$branch_id,$account_id);
     
     @endphp

@if($account_code->account_name == 'Value Added Tax (VAT)')

<?php

                        
                         if ($amount['debit'] == 0){
                        $total_vat=$amount['credit'];
                       }
                       else{
                         $total_vat=$amount['debit'];
                         }
                                            
  ?>
                          

                                        

@else

 <?php
                   
                            

                      if($account_code->account_name == 'Deffered Tax'){
                       $total_credit_liability  =    $total_credit_liability + ($amount['credit']-$amount['debit']) +$net_profit['tax_for_second_date'];
                                              
                        

                         }
                         else{
                          
                         $total_credit_liability  +=($amount['credit']-$amount['debit']);                     
                         
                       
                           }

                       
                        ?>                           
                              
                                 
  @endif                  
 @endforeach              ​
 ​@endforeach

 ​@endforeach


                       ​<td><b>{{ number_format($total_credit_liability + $total_vat,2) }}</b></td>

                   ​</tr>  

<tr>
                        <td colspan="4" style="text-align: center"><b>Equities</b></td>   <!-- //sehemu ya equity ==================================================================== -->
                  
    @foreach($equity->where('added_by',auth()->user()->added_by)   as $account_class)
<?php    $c++ ; 
  

?>

  @foreach($account_class->groupAccount->where('added_by',auth()->user()->added_by)->where('disabled','0')  as $group)
                             
@foreach($group->accountCodes->where('added_by',auth()->user()->added_by)->where('disabled','0') as $account_code)

 @php
     $account_id=$account_code->id;
      $amount=App\Traits\Calculate_Balance::get_amount($start_date,$branch_id,$account_id);
     
     @endphp

 <?php

                         if($account_code->account_codes == 31101){
                         $total_credit_equity    =$total_credit_equity + $net_profit['profit_for_second_date'];
                       
                         }else{
                         $total_credit_equity    +=($amount['credit']-$amount['debit']) ;
                         
                         } ?>
                      
                                 
                  
 @endforeach              ​
 ​@endforeach
               
 ​@endforeach
                   
   
                       ​<td><b>{{ number_format($total_credit_equity,2) }}</b></td>
                    </tr>

                  <tr>
                        <td colspan="4" style="text-align: center">
                            <b> Liabilities And Equities</b>
                        </td>

                        <td><b>{{ number_format($total_credit_liability+$total_credit_equity + $total_vat,2) }}</b></td>
                    </tr>
                    </tbody>
                   
               
                    
                </table>
</div>
    @endif

</body>
</html>