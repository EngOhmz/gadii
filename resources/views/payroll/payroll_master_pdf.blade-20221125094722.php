<!DOCTYPE html>
<html>
<head>
    <title>Larave Generate Invoice PDF - Nicesnippest.com</title>
</head>
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
        font-size:14px;
      color:white;
    }
    table tr td{
        font-size:12px;
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
            position: fixed;
            bottom: 0;
              margin-top:30px;
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
  <!-- Define header and footer blocks before your content -->


  <!-- Wrap the content of your PDF inside a main tag -->
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
                    <center><b>  Payroll Master Report
                    for the Month  {{Carbon\Carbon::parse($month)->format('F Y')}}</b> </center>
                </div>
        <td>
         
        </tr>

</tfoot>
    </table>
</div>


                         <?php 

                                  $paye_amount  = 0;
                                        $nssf_amount = 0;;
                                        $wcf_amount = 0;
                                         $nhif_amount = 0;
                                        $sdl_amount = 0;
                                        $advance_amount = 0;
                                        $loan_amount = 0;
                                        $allowance  = 0;
                                     
                                    $total_salary = 0;                                 
                                      $total_paye  = 0;
                                        $total_nssf = 0;;
                                        $total_wcf = 0;
                                         $total_nhif = 0;
                                        $total_sdl = 0;
                                        $total_advance = 0;
                                        $total_loan = 0;
                                        $total_overtime = 0;
                                        $total_allowance  = 0;
                                       $total_fine=0;
                                       ?>

<div class="table-section bill-tbl w-100 mt-10">
    <table class="table  w-100 mt-10">
<thead>

        <tr>
      
                                 <th>Name</th>
                            <th>Gross Salary</th>
                            <th>PAYE</th>
                       <th>NSSF</th>
                            <th>WCF</th>
                          <th>NHIF</th>
                          <th> SDL </th>
                          <th>Advance </th>
                            <th> Employee Loan</th>
                             <th> Overtime</th>
                           <th>Allowance</th>
                           <th>Fine Deduction</th>
                            <th>Net Salary</th>
               
        </tr>
</thead>
                               <tbody>


                        @foreach ($check_existing_payment as $row)
                                <?php 
                                       $a = App\Models\User::where('id', $row->user_id)->first();
                                  $salary = App\Models\Payroll\ SalaryPaymentDetails::where('salary_payment_id', $row->id)->where('salary_payment_details_label', 'Basic Salary')->sum('salary_payment_details_value');                                   
                                      $paye  = App\Models\JournalEntry::where('payment_id', $row->id)->where('name', 'PAYE Payment')->first();;
                                        $nssf = App\Models\JournalEntry::where('payment_id', $row->id)->where('name', 'NSSF Payment')->first();;
                                        $wcf = App\Models\JournalEntry::where('payment_id', $row->id)->where('name', 'WCF Contribution Payment')->first();;
                                         $nhif = App\Models\JournalEntry::where('payment_id', $row->id)->where('name', 'NHIF - Heath Insurance Expense Payment')->first();;
                                        $sdl = App\Models\JournalEntry::where('payment_id', $row->id)->where('name', 'SDL Payment')->first();;
                                        $advance = App\Models\JournalEntry::where('payment_id', $row->id)->where('name', 'Advance Salary Payment')->first();;
                                        $loan = App\Models\JournalEntry::where('payment_id', $row->id)->where('name', 'Employee Loan Payment')->first();;
                                        $overtime =App\Models\Payroll\ SalaryPaymentDetails::where('salary_payment_id', $row->id)->where('salary_payment_details_label', 'Overtime Amount')->sum('salary_payment_details_value');
                                        $allowance  = App\Models\Payroll\SalaryPaymentAllowance::where('salary_payment_id', $row->id)->sum('salary_payment_allowance_value');;

                             if(!empty($paye)){
                               $paye_amount=$paye->debit;
                             }
                               else{
                                 $paye_amount=0;
                           }

                      if(!empty($nssf)){
                               $nssf_amount=$nssf->debit;
                             }
                               else{
                                 $nssf_amount=0;
                           }
                        if(!empty($wcf)){
                               $wcf_amount=$wcf->debit;
                             }
                               else{
                                 $wcf_amount=0;
                           }
                          if(!empty($nhif)){
                               $nhif_amount=$nhif->debit;
                             }
                               else{
                                 $nhif_amount=0;
                           }
                    if(!empty($sdl)){
                               $sdl_amount=$sdl->debit;
                             }
                               else{
                                 $sdl_amount=0;
                           }
                        if(!empty($advance)){
                               $advance_amount=$advance->debit;
                             }
                               else{
                                 $advance_amount=0;
                           }
                           if(!empty($loan)){
                               $loan_amount=$loan->debit;
                             }
                               else{
                                 $loan_amount=0;
                           }
                         

                                       ?>
                            <tr>
                                                                    
                                 <td><?php echo $a->name; ?></td>
                                 <td>{{number_format( $salary,2)}} </td>
                                   <td>{{number_format( $paye_amount,2)}} </td>
                                     <td>{{number_format( $nssf_amount,2)}} </td>
                                     <td>{{number_format( $wcf_amount,2)}} </td>
                                      <td>{{number_format( $nhif_amount,2)}} </td>  
                                   <td>{{number_format( $sdl_amount,2)}} </td>   
                               <td>{{number_format( $advance_amount,2)}} </td>
                             <td>{{number_format( $loan_amount,2)}} </td>  
                              <td>{{number_format( $overtime,2)}} </td>    
                               <td>{{number_format(  $allowance,2)}} </td>
                             <td>{{number_format(  $row->fine_deduction,2)}} </td>    
                              <td>{{number_format(($salary+$allowance +$overtime) - ($paye_amount+$nssf_amount+$advance_amount+$loan_amount + $row->fine_deduction) ,2)}} </td>            
                            </tr>


                           <?php 
                                     
                                    $total_salary += $salary;                                 
                                      $total_paye  += $paye_amount;
                                        $total_nssf += $nssf_amount;;
                                        $total_wcf +=$wcf_amount;
                                         $total_nhif += $nhif_amount;
                                        $total_sdl +=$sdl_amount;
                                        $total_advance += $advance_amount;
                                        $total_loan += $loan_amount;
                                        $total_overtime += $overtime;
                                        $total_allowance  += $allowance;
                                      $total_fine  += $row->fine_deduction;
                                       ?>
                        
                        @endforeach
                        </tbody>
<tfoot>
<tr>
                                                                
                                 <td><b>Total</b></td>
                                 <td>{{number_format( $total_salary,2)}} </td>
                                   <td>{{number_format( $total_paye,2)}} </td>
                                     <td>{{number_format( $total_nssf,2)}} </td>
                                     <td>{{number_format( $total_wcf,2)}} </td>
                                      <td>{{number_format( $total_nhif,2)}} </td>  
                                   <td>{{number_format( $total_sdl,2)}} </td>   
                               <td>{{number_format( $total_advance,2)}} </td>
                                      <td>{{number_format( $total_loan,2)}} </td>  
                              <td>{{number_format( $total_overtime,2)}} </td>    
                               <td>{{number_format(  $total_allowance,2)}} </td>   
                             <td>{{number_format(  $total_fine,2)}} </td> 
                              <td>{{number_format(($total_salary+$total_allowance +$total_overtime) - ($total_paye+$total_nssf+$total_advance+$total_loan + $total_fine) ,2)}} </td>

</tr>
</tfoot>
    </table>



</div>

<script>

</body>
</html>



