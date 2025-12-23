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
        font-size:15px;
      background-color: #2F75B5;
      color:white;
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
                    <center><b> TRIAL BALANCE SUMMARY FOR THE PERIOD BETWEEN 
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
                    <thead>

                    <tr>
                    
                         <th>Account</th>
                         <th>Debit</th>
                         <th>Credit</th>
                         
                    </tr>
                    </thead>
                     <tbody>

               <?php
               $c=0;     
              $credit_total = 0;
              $debit_total = 0;
            

?>            
     
     @foreach($data->where('added_by',auth()->user()->added_by) as $account_class)
<?php    $c++ ;  ?>
 <?php
           $total_dr_unit=0;
                         $total_cr_unit=0;
   $total_vat_cr=0;;
               $total_vat_dr=0;;
  
?>            
                          <tr>
                        <td colspan="1" ><b>{{ $c }} . {{ $account_class->class_name  }}</b></td>
                        <?php if($c == 1){ ?>
                           
                           
                    <?php    } ?>
                   


               
  @foreach($account_class->groupAccount->where('added_by',auth()->user()->added_by)  as $group)
 @if($group->name != 'Retained Earning/Loss')                          
@foreach($group->accountCodes->where('added_by',auth()->user()->added_by) as $account_code)
 @if($account_code->account_name != 'Deffered Tax' && $account_code->account_name != 'Value Added Tax (VAT)')

<?php
                                   
    
                       
                        

                        $cr = \App\Models\JournalEntry::where('account_id', $account_code->id)->whereBetween('date',
                            [$start_date, $end_date])->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->id)->whereBetween('date',
                            [$start_date, $end_date])->where('added_by',auth()->user()->added_by)->sum('debit');
                            

                                        
                          $total_dr_unit  +=($dr-$cr);
                        $total_cr_unit  +=($cr-$dr);

                    if ($account_class->class_type == 'Assets' || $account_class->class_type == 'Expense'){
                                      $debit_total += $dr-$cr ;
                           }else{
                                  $credit_total += $cr-$dr ;
                           }
                     
                        
 ?> 
                     
                        
    @elseif($account_code->account_name == 'Value Added Tax (VAT)')


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

                        $cr_in = \App\Models\JournalEntry::where('account_id', $vat_in->account_id)->whereBetween('date',
                            [$start_date, $end_date])->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr_in = \App\Models\JournalEntry::where('account_id', $vat_in->account_id)->whereBetween('date',
                            [$start_date, $end_date])->where('added_by',auth()->user()->added_by)->sum('debit'); 

                        $cr_out = \App\Models\JournalEntry::where('account_id',  $vat_out->account_id)->whereBetween('date',
                            [$start_date, $end_date])->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr_out = \App\Models\JournalEntry::where('account_id', $vat_out->account_id)->whereBetween('date',
                            [$start_date, $end_date])->where('added_by',auth()->user()->added_by)->sum('debit');
                            

                         $total_in= $dr_in- $cr_in ;
                          $total_out = $cr_out - $dr_out ;

                         if ($total_in - $total_out < 0){
                        $total_vat_cr=($total_in -  $total_out) * -1;
                         $total_cr_unit=$total_cr_unit + (($total_in -  $total_out) * -1);
                        $credit_total=$credit_total +$total_vat_cr;
                       }
                       else{
                         $total_vat_dr=$total_in -  $total_out;
                   $total_dr_unit=$total_cr_unit + (($total_in -  $total_out) * -1);
                    $debit_total= $debit_total +$total_vat_dr;
                         }
  ?>
                          
                        


 @endif  
   @endforeach   
 @endif             
  @endforeach

 @if ($account_class->class_type == 'Assets' || $account_class->class_type == 'Expense')
                                        <td>{{ number_format( $total_dr_unit ,2) }}  </td>
                                 <td>{{ number_format(0 ,2) }} </td>
                           @else
                                <td>{{ number_format(0 ,2) }} </td>
                            <td>{{ number_format( $total_cr_unit ,2) }}  </td> 
                           @endif 
</tr>

  @endforeach
 
                    </tbody>

 <tfoot>
                    <tr>
                           
                        <td><b>Total</b></td>
                        
                        <td><b>{{number_format($debit_total, 2)}}</b></td>
                        <td><b>{{number_format($credit_total ,2)}}</b></td>
                    </tr>
                    </tfoot>
                    
                </table>
</div>
    @endif

</body>
</html>