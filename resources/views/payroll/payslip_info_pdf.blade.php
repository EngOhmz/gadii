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
   .mt-20{
        margin-top:20px;
    }
.mt-90{
        margin-top:150px;
    }

    .text-center{
        text-align:center !important;
    }
    .w-100{
        width: 100%;
    }
      .w-100-right{
         width: 100%;
            float: right;
    }
       .w-50{
        width: 50%;
    }
    .w-50-right{
        width: 49%;
            float: right;
    }
      .w-50-left{
        width: 49%;
            float: left;
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
        background: #F4F4F4;
        font-size:15px;
    }
    table tr td{
        font-size:13px;
    }
    table{
        border-collapse:collapse;
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
            bottom: 0;
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
        .head{
            font-size: 15px;
        }
.margin{
            margin-top: -1%;
            font-size: 10px;
    }

</style>
<body>
 <?php
$settings= App\Models\System::where('added_by',auth()->user()->added_by)->first();

?>
<div class="head-title">
 <h1 class="text-center m-0 p-0 head"><img class="pl-lg" style="width: 120px;height: 120px;" src="{{url('public/assets/img/logo')}}/{{$settings->picture}}"> </h1><br>
    <h4 class="text-center m-0 p-0 head">{{$settings->name}}</h4><br>
     <p class="text-center  margin">{{ $settings->address }}</p>
      <p class="text-center  margin"> Phone: {{  $settings->phone}}</p>
      <p class="text-center margin ">E: {{$settings->email}}</p>

<br>
    <h3 class="text-center m-0 p-0">Payslip <?php echo date('F  Y', strtotime($month)) ?></h3>
</div>
<div class="add-detail ">
   <table class="table w-100 ">
<tfoot>
       
    
</tfoot>
    </table>


    <div style="clear: both;"></div>
</div>
<div class="table-section bill-tbl w-100 mt-10">
    <table class="table w-100 mt-10">
<tbody>
       
        <tr> <td> <strong>Name  </strong></td><td> <?php echo $employee_info->name; ?></td></tr>
                 <tr> <td> <strong>Department  </strong></td><td> <?php echo $employee_info->department->name; ?></td></tr>
                  <tr> <td> <strong>Payslip No </strong></td><td> {{$pay->payslip_number}}</td></tr>
            <tr><td><strong>Pay Date </strong></td><td> @if(!empty($check_existing_payment)) <?php echo date('d/m/Y', strtotime($check_existing_payment->paid_date)); ?> @endif</td> </tr>       
                    
</tbody>
    </table>
</div>
<!--
<div class="table-section bill-tbl w-100 mt-10">
    <table class="table w-100 mt-10">
        <tr>
            <th class="w-50">Payment Method</th>
            <th class="w-50">Shipping Method</th>
        </tr>
        <tr>
            <td>Cash On Delivery</td>
            <td>Free Shipping - Free Shipping</td>
        </tr>
    </table>
</div>
-->

                                

<div class="table-section bill-tbl w-50-left">

    <table class="table w-100 mt-20">
<tr>
                            <th colspan="2">
                                Earnings</th>
                        </tr>
<thead>
        <tr>

            <th class="w-50">Type of Pay</th>
            <th class="w-50">Amount</th>
        </tr>
</thead>
        <tbody>
             <?php
                        $total_hours_amount = 0;
                         foreach ($salary_payment_details_info as $v_payment_details) :
                            ?>
                            <tr>
                                 <td>
                                    <strong> <?php
                                        if ($v_payment_details->salary_payment_details_label == 'overtime_salary' || $v_payment_details->salary_payment_details_label == 'hourly_rates') {
                                            $small = ($v_payment_details->salary_payment_details_label == 'overtime_salary' ? ' <small>( ' . lang('per_hour') . ')</small>' : '');
                                            $label = lang($v_payment_details->salary_payment_details_label) . $small;
                                        } else {
                                            $label = $v_payment_details->salary_payment_details_label;
                                        }
                                        echo $label; ?>
                                         </strong>
                                </td>
                                <td> <?php
                                    if (is_numeric($v_payment_details->salary_payment_details_value)) {
                                        if ($v_payment_details->salary_payment_details_label == 'overtime_salary') {
                                            $rate = $v_payment_details->salary_payment_details_value;
                                        } elseif ($v_payment_details->salary_payment_details_label == 'hourly_rates') {
                                            $rate = $v_payment_details->salary_payment_details_value;
                                        }
                                        $total_hours_amount += $v_payment_details->salary_payment_details_value;
                                        echo number_format($v_payment_details->salary_payment_details_value, 2);
                                    } else {
                                        echo $v_payment_details->salary_payment_details_value;
                                    }
                                    ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <?php
                        $total_allowance = 0;
                        if (!empty($allowance_info)):foreach ($allowance_info as $v_allowance) :
                            ?>
                            <tr>
                                <td>
                                    <strong> <?php echo $v_allowance->salary_payment_allowance_label ?>
                                         </strong></td>
                                <td><?php echo number_format($v_allowance->salary_payment_allowance_value, 2); ?></td>
                            </tr>
                            <?php
                            $total_allowance += $v_allowance->salary_payment_allowance_value;
                        endforeach;
                            ?>
                        <?php endif; ?>
       </tbody>
</table>
</div>

 <?php
                $deduction = 0;
                if (!empty($deduction_info)):
                    ?>

<div class="table-section bill-tbl w-50-right">

    <table class="table w-100 mt-20">
<tr>
                                <th colspan="2">
                                    <strong>Deductions</strong></th>
                            </tr>
<thead>
        <tr>

            <th class=" col-sm-2 w-50">Type of Pay</th>
            <th class="w-50">Amount</th>
        </tr>
</thead>
        <tbody>
            
                        <?php foreach ($deduction_info as $v_deduction): ?>

                            <tr>
                                 <td>
                                    <strong> <?php echo $v_deduction->salary_payment_deduction_label; ?>
                                         </strong>
                                </td>
                                <td><?php
                                        echo number_format($v_deduction->salary_payment_deduction_value, 2);
                                        ?></td>
                            </tr>
                        <?php
                                $deduction += $v_deduction->salary_payment_deduction_value;
                            endforeach;
                            ?>
                      
                     
       </tbody>
</table>
</div>
   <?php endif; ?>




<br><br>
<div class="table-section bill-tbl w-100 mt-90">

    <table class="table w-100 mt-20">
<tr>
                                <th colspan="2">
                                    <strong>Total Details</strong></th>
                            </tr>

        <tbody>
            
                      <?php if (!empty($check_existing_payment)): ?>
                        <tr>
                            <td ><strong> Gross Salary </strong>
                            </td>
                            <td>&nbsp; <?php
                                if (!empty($rate)) {
                                    $rate = $rate;
                                } else {
                                    $rate = 0;
                                }
                                $gross = $total_hours_amount + $total_allowance - $rate;
                                echo number_format($gross, 2);
                                ?></td>
                        </tr>

                        <tr>
                            <td><strong>Total Deduction </strong>
                            </td>

                            <td> &nbsp; <?php
                                $total_deduction = $deduction;
                                echo number_format($total_deduction, 2);
                                ?></td>
                        </tr>
                    <?php endif; ?>
                    <?php if (!empty($check_existing_payment)): ?>
                        <tr>
                            <td ><strong>Net Salary</strong></td>

                            <td>&nbsp; <?php
                                $net_salary = $gross - $deduction;
                                echo number_format($net_salary, 2);
                                ?></td>
                        </tr>
                    <?php endif; ?>
                    <?php if (!empty($check_existing_payment->fine_deduction)): ?>
                        <tr>
                            <td><strong>Fine Deduction </strong>
                            </td>

                            <td>&nbsp; <?php
                                $net_salary = $gross - $deduction;
                                echo number_format($check_existing_payment->fine_deduction, 2);
                                ?></td>
                        </tr>
                    <?php endif; ?>
                    <tr>
                        <td><strong>Paid Amount</strong></td>

                        <td style="font-weight: bold;"><?php
                            if (!empty($check_existing_payment->fine_deduction)) {
                                $paid_amount = $net_salary - $check_existing_payment->fine_deduction;
                            } else {
                                $paid_amount = $net_salary;
                            }
                            echo number_format($paid_amount, 2);
                            ?></td>
                    </tr>
       </tbody>
</table>



<br><br><br><br>
<table class="table w-100 mt-10">
<tfoot>
<tr>
         <td style="width: 50%;">
            <div class="left" style="">
        <div>........................................................</div>
         <div><b>ACCOUNTS OFFICER</div>        
          </div>  </td>

            <td style="width: 50%;">
            <div class="right" style="">
        <div>............................................................... </div>
        <div><b>SIGNATURE</b></div></td>

</tr>

<tr>
            <td style="width: 50%;">
            <div class="left" style="">
        <div></div>
        <div></div>
        
        </div></td>

<td style="width: 50%;">
            <div class="right" style="">
        <div></div>
        <div></div></td>


</tr>

 <tr>
            <td style="width: 50%;">
            <div class="left" style="">
        <div>............................................................... </div>
        <div><b>EMPLOYEE</b></div>
        
        </div></td>

<td style="width: 50%;">
            <div class="right" style="">
        <div>............................................................... </div>
        <div><b>SIGNATURE</b></div></td>


</tr>


  </tfoot>    
</table>

</div>
   



<footer>
This is a computer generated invoice
</footer>
</body>
</html>