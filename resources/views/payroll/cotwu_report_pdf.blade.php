<!DOCTYPE html>
<html>
<head>
    <title>DOWNLOAD PDF</title>
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
                    <center><b>  COTWU Report
                    for the Month  {{Carbon\Carbon::parse($month)->format('F Y')}}</b> </center>
                </div>
        <td>
         
        </tr>

</tfoot>
    </table>
</div>


                         <?php 
                                     
                                       $vic_amount = 0;;
                                       $total_salary = 0;
                                  $total_amount=0;

                                       ?>

<div class="table-section bill-tbl w-100 mt-10">
    <table class="table  w-100 mt-10">
<thead>

        <tr>
      
                              <th>#</th>                        
                                 <th>Name</th>
                                <th>Basic Salary</th>
                             <th>Amount</th>
               
        </tr>
</thead>
 <tbody>
                        <?php 
                                        $cot_amount = 0;;
                                       $total_salary = 0;
                                  $total_amount=0;
                                       ?>

                      
                          @if (!empty($check_existing_payment))
                    <?php $total_paid_amount=0; ?>
                        @foreach ($check_existing_payment as $row)
                        <tr>
                           <td> <?php echo $loop->iteration; ?></td>
                             <?php
                                       $a = App\Models\User::where('id', $row->user_id)->first();
                                       ?>
                                 <td><?php echo $a->name; ?></td>


                              <?php
    
                 $salary = App\Models\Payroll\SalaryPaymentDetails::where('salary_payment_id', $row->id)->where('salary_payment_details_label', 'Basic Salary')->sum('salary_payment_details_value'); 
                   $amount = App\Models\Payroll\SalaryPaymentDeduction::where('salary_payment_id', $row->id)->where('salary_payment_deduction_label', 'COTWU')->sum('salary_payment_deduction_value'); 

                              if(!empty($amount)){
                               $cot_amount=$amount;
                             }
                               else{
                                 $cot_amount=0;
                           }

?>
                              <td>{{number_format($salary ,2)}} </td>
                              <td>{{number_format( $cot_amount  ,2)}} </td>                               
     
                            
                          
                         
                        </tr>
                       
                     <?php 
                                     
                                    $total_salary += $salary;  
                                  $total_amount+= $cot_amount ;                               
                                       ?>
                         @endforeach
                           @endif
                        </tbody>
                     <tfoot>
<tr>
                                     <td><b>Total</b></td>
                                     <td></td>                       
                                 <td><b>{{number_format( $total_salary,2)}}</b></td>
                                 <td><b>{{number_format( $total_amount,2)}} </b></td>


</tr>
</tfoot>
    </table>



</div>

<script>

</body>
</html>



