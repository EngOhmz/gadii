<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Payslip</title>

    <style type="text/css">
        .bd {
            width: 100%;
        }

        .banner {
            border-bottom: 2px solid black;
        }

        .banner td {
            border: 0px;
        }

        .banner td p {
            font-size: 16px;
            font-weight: bold;
            margin-left: 10px;
        }

        table {
            font-family: Arial, Helvetica, sans-serif;
            width: 100%;
            border-collapse: collapse;
        }

        th {
            padding: 8px 0 8px 5px;
            text-align: left;
            font-size: 13px;
            border: 1px solid black;
            background-color: #F2F2F2;
        }

        td {
            padding: 10px 0 8px 8px;
            
            font-size: 13px;
            color: black;
            border: 1px solid black;
        }

        .head {
            background-color: #F2F2F2;
            font-size: 14px;
            padding: 15px 5px 8px 15px;
            border-radius: 5px;
        }

        .head tr td {
            text-align: left;
            font-size: 15px;
            border: 0px;
            padding-left: 20px;
        }

        .tbl1 {
            width: 49%;
            float: left;
        }

        .tbl2 {
            width: 49%;
            float: right;
        }

    .tbl_total {
            width: 49%;
            float: right;
margin-top:250px;
margin-right:-370px;
        }

        .tbl_total tr td {
            border: 0px;
        }

     

        .bg td {
            background-color: #F2F2F2;
        }
    </style>
</head>
<body>
   
       
      
                        <?php
$settings= App\Models\System::first();


?>
       
 <div class="bd">
<div id="payment_receipt">
        <div style="width: 100%;">
            <div align="center">
                <table class="head">
                    <tr>
                        <td colspan="3" style="text-align: center; font-size: 18px; padding-bottom: 18px;">
                            <strong>Payslip
                                <br/>Salary Month
                                : <?php echo date('F  Y', strtotime($month)) ?>
                            </strong></td>
                    </tr>
                    <tr>
                      
                        <td>
                            <strong>Name  :</strong> <?php echo $employee_info->name; ?>
                        </td>
                        <td><strong>Payslip No :</strong> <?php echo $pay->payslip_number; ?></td>
                    </tr>
                    <tr>
                        <td><strong>Mobile :</strong> <?php echo $employee_info->phone; ?></td>
                      
                            <td><strong>Email :</strong> <?php echo $employee_info->email; ?></td>
                      
                    </tr>
                    <tr>
                        <td><strong>Department :</strong> <?php echo $employee_info->department->name; ?>
                        </td>
                        <td><strong>Designation
                                :</strong> <?php echo $employee_info->designation->name; ?></td>
                        
                    </tr>
                </table>
                <br/><br/>
            </div>
            <div align="center">
                <div class="tbl1">
                   <table>
                        <tr>
                            <th colspan="2"
                                style="border: 0px; font-size: 20px;padding-left:0px;background: none;color: #000">
                                Earnings</th>
                        </tr>
                        <tr>
                            <th>Type of Pay</th>
                            <th>Amount</th>
                        </tr>
                        <?php
                        $total_hours_amount = 0;
                         foreach ($salary_payment_details_info as $v_payment_details) :
                            ?>
                            <tr>
                                 <td style="text-align: right">
                                    <strong> <?php
                                        if ($v_payment_details->salary_payment_details_label == 'overtime_salary' || $v_payment_details->salary_payment_details_label == 'hourly_rates') {
                                            $small = ($v_payment_details->salary_payment_details_label == 'overtime_salary' ? ' <small>( ' . lang('per_hour') . ')</small>' : '');
                                            $label = lang($v_payment_details->salary_payment_details_label) . $small;
                                        } else {
                                            $label = $v_payment_details->salary_payment_details_label;
                                        }
                                        echo $label; ?>
                                        :&nbsp;&nbsp; </strong>
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
                                <td style="text-align: right">
                                    <strong> <?php echo $v_allowance->salary_payment_allowance_label ?>
                                        :&nbsp;&nbsp; </strong></td>
                                <td><?php echo number_format($v_allowance->salary_payment_allowance_value, 2); ?></td>
                            </tr>
                            <?php
                            $total_allowance += $v_allowance->salary_payment_allowance_value;
                        endforeach;
                            ?>
                        <?php endif; ?>
                    </table>
                </div>
               <?php
                $deduction = 0;
                if (!empty($deduction_info)):
                    ?>
                    <div class="tbl2">
                        <table>
                            <tr>
                                <th colspan="2"
                                    style="border: 0px; font-size: 20px;padding-left:0px;background: none;color: #000">
                                    <strong>Deductions</strong></th>
                            </tr>
                            <tr>
                                <th>Type of Pay</th>
                                <th>Amount</th>
                            </tr>
                            <?php foreach ($deduction_info as $v_deduction): ?>
                                <tr>
                                    <td style="text-align: right">
                                        <strong><?php echo $v_deduction->salary_payment_deduction_label; ?> :&nbsp;&nbsp;</strong>
                                    </td>

                                    <td>&nbsp; <?php
                                        echo number_format($v_deduction->salary_payment_deduction_value, 2);
                                        ?></td>
                                </tr>
                                <?php
                                $deduction += $v_deduction->salary_payment_deduction_value;
                            endforeach;
                            ?>
                        </table>
                    </div>
                <?php endif; ?>
</br></br>

  <div class="tbl_total">
                   <table class="">
                    </br></br><tr>
                     <td> </td>
                        <td  colspan="2"
                            style="border: 0px; font-size: 20px;background: none;color: #000;text-align: right;">
                            <strong>Total Details</strong></td>
                    </tr>
                    <?php if (!empty($check_existing_payment)): ?>
                        <tr>
                            <td style="text-align: right;"  colspan="4"><strong> Gross Salary :&nbsp;&nbsp;</strong>
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
                            <td style="text-align: right"  colspan="4"><strong>Total Deduction :&nbsp;&nbsp;</strong>
                            </td>

                            <td> &nbsp; <?php
                                $total_deduction = $deduction;
                                echo number_format($total_deduction, 2);
                                ?></td>
                        </tr>
                    <?php endif; ?>
                    <?php if (!empty($check_existing_payment)): ?>
                        <tr>
                            <td style="text-align: right"  colspan="4"><strong>Net Salary :&nbsp;&nbsp;</strong></td>

                            <td>&nbsp; <?php
                                $net_salary = $gross - $deduction;
                                echo number_format($net_salary, 2);
                                ?></td>
                        </tr>
                    <?php endif; ?>
                    <?php if (!empty($check_existing_payment->fine_deduction)): ?>
                        <tr>
                            <td style="text-align: right"  colspan="4"><strong>Fine Deduction :&nbsp;&nbsp;</strong>
                            </td>

                            <td>&nbsp; <?php
                                $net_salary = $gross - $deduction;
                                echo number_format($check_existing_payment->fine_deduction, 2);
                                ?></td>
                        </tr>
                    <?php endif; ?>
                    <tr class="bg">
                        <td style="text-align: right;font-weight: bold"  colspan="4"><strong>Paid Amount
                                :&nbsp;&nbsp;</strong></td>

                        <td style="font-weight: bold;">&nbsp; <?php
                            if (!empty($check_existing_payment->fine_deduction)) {
                                $paid_amount = $net_salary - $check_existing_payment->fine_deduction;
                            } else {
                                $paid_amount = $net_salary;
                            }
                            echo number_format($paid_amount, 2);
                            ?></td>
                    </tr>
                </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<footer>

</footer>
</body>
</html>