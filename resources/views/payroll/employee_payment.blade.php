@extends('layouts.master')


@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <!-- *********     Employee Search Panel ***************** -->
            <div class="card-header">
                <h4>Make Payment</h4>
            </div>

            <form id="form" role="form" enctype="multipart/form-data" action="{{route('make_payment.store')}}"
                method="post" class="form-horizontal form-groups-bordered">
                @csrf
                <div class="card-body">
                    <div class="form-group offset-3">
                        <label for="field-1" class="col-sm-3 control-label">Select Department <span class="required">
                                *</span></label>

                        <div class="col-sm-5">
                            <select required name="departments_id" class="form-control select_box">
                                <option value="">Select Department </option>
                                <?php if (!empty($all_department_info)): foreach ($all_department_info as $v_department_info) :
                                    if (!empty($v_department_info->name)) {
                                        $deptname = $v_department_info->name;
                                    } else {
                                        $deptname = "Undifined Department";
                                    }
                                    ?>
                                <option value="<?php echo $v_department_info->id; ?>" <?php
                                        if (!empty($departments_id)) {
                                            echo $v_department_info->id == $departments_id ? 'selected' : '';
                                        }
                                        ?>><?php echo $deptname ?></option>
                                <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group offset-3">
                        <label class="col-sm-3 control-label">Select Month <span class="required"> *</span></label>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <input required type="month" value="<?php
                                if (!empty($payment_month)) {
                                    echo $payment_month;
                                }
                                ?>" class="form-control monthyear" name="payment_month" data-format="yyyy/mm/dd">

                                
                            </div>
                        </div>
                    </div>
                    <div class="form-group offset-3" id="border-none">
                        <label for="field-1" class="col-sm-3 control-label"></label>
                        <div class="col-sm-5">
                            <button id="submit" type="submit" name="flag" value="1" class="btn btn-primary btn-block">Go
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div><!-- ******************** Employee Search Panel Ends ******************** -->
        <?php if (!empty($user_id)): ?>

 <?php
$total_amount=0;
      $total_advance = 0;
            if (!empty($advance_salary)) {
                                            foreach ($advance_salary as  $v_advance) {                                            
                                                    $total_advance += $v_advance->advance_amount;                                               
                                            }
                                        }
    $total_loan = 0;
                                        if (!empty($loan_info)) {
                                            foreach ($loan_info as  $v_loan) {                                            
                                                    $total_loan += $v_loan->loan_amount;                                               
                                            }
                                        }

        if (!empty($total_hours)) {
            $total_hour = $total_hours['total_hours'];
            $total_minutes = $total_hours['total_minutes'];
            if ($total_hour > 0) {
                $hours_ammount = $total_hour * $employee_info->salaryTemplates->hourly_rate;
            } else {
                $hours_ammount = 0;
            }
            if ($total_minutes > 0) {
                $amount = round($employee_info->hourly_rate / 60, 2);
                $minutes_ammount = $total_minutes * $amount;
            } else {
                $minutes_ammount = 0;
            }
            $total_hours_amount = $hours_ammount + $minutes_ammount;
        }
        if (!empty($employee_info->salaryTemplates->basic_salary)) {
           $total_allowance = 0;
                                        if (!empty($allowance_info)) {
                                            foreach ($allowance_info as  $v_allowance) {
                                                    $total_allowance += $v_allowance->allowance_value; 
                                            }
                                        }
                                     $total_deduction = 0;
                                        if (!empty($deduction_info)) {
                                            foreach ($deduction_info as $v_deduction) {                                            
                                                  $total_deduction += $v_deduction->deduction_value; 
                                            }
                                        }
             $total_overtime=0;
            if (!empty($overtime_info)) {
               foreach ($overtime_info as  $v_overtime) {                                    
                $total_overtime += $v_overtime->overtime_amount;                                               
                                            }
               
              
                $total_amount =   $total_overtime +  $total_allowance;
            }
        }
        ?>

<form role="form"  data-parsley-validate="" novalidate="" enctype="multipart/form-data" action="{{route('save_payment')}}" method="post" class="form-horizontal form-groups-bordered">
        @csrf   
        <div class="row">
                <div class="col-lg-3" data-spy="scroll" data-offset="0">
                    <div class="row">

                        <div class="card">
                            <!-- Default panel contents -->
                            <div class="card-header">

                                <strong>Payment For<?php
                                    echo ' <span class="text-danger">' . date('F Y', strtotime($payment_month)) . '</span>';
                                    ?> to <?php echo $employee_info->user->name ?></strong>

                            </div>
                            <div class="card-body">
                                <div class="">
                                    <label class="control-label">Gross Salary </label>
                                    <input type="text" name="house_rent_allowance" disabled value="<?php

                                if (!empty($total_hours_amount)) {
                                    echo $gross = round($total_hours_amount, 2);
                                    $total_deduction = 0;
                                } else {
                                    echo $gross = $employee_info->salaryTemplates->basic_salary + $total_amount;
                                }
                                ?>" class="salary form-control">
                                </div>
                                <div class="">
                                    <label class="control-label">Total Deduction</label>
                                    <input type="text" name="" disabled value="<?php
                                echo $deduction =  $total_deduction +  $total_advance +$total_loan;
                                ?>" class="salary form-control">
                                </div>
                                <div class="">
                                    <label class="control-label">Net Salary</label>
                                    <input type="text" id="net_salary" name="other_allowance" disabled value="<?php
                                echo $net_salary = $gross - $deduction;
                                ?>" class="salary form-control">
                                </div>
                                <?php
                            $total_award = 0;
                            if (!empty($award_info)): foreach ($award_info as $v_award_info) :
                                ?>
                                <?php if (!empty($v_award_info->award_amount)): ?>
                                <div class="">
                                    <label class="control-label">Award
                                        <small>( <?php echo $v_award_info->award_name; ?> )</small>
                                    </label>
                                    <input type="text" name="other_allowance" disabled id="award"
                                        value="<?php echo $v_award_info->award_amount; ?>" class="award form-control">
                                    <input type="hidden" name="award_name[]" id="award"
                                        value="<?php echo $total_award += $v_award_info->award_amount; ?>"
                                        class="form-control">
                                </div>
                                <?php endif; ?>
                                <?php endforeach; ?>
                                <?php endif; ?>
                                <input type="hidden" name="total_award" id="total_award" value="" class="form-control">
                                <div class="">
                                    <label class="control-label">Fine Deduction </label>
                                    <input type="text" data-parsley-type="number" name="fine_deduction"
                                        id="fine_deduction" value="<?php
                                       if (!empty($check_salary_payment->fine_deduction)) {
                                           echo $check_salary_payment->fine_deduction;
                                       }
                                       ?>" class="form-control">
                                </div>
                                <div class="">
                                    <label class="control-label"><strong>Payment Amount </strong></label>
                                    <input type="text" disabled="" value="<?php echo $net_salary + $total_award; ?>"
                                        class="payment_amount form-control">
                                </div>
                                <input type="hidden" name="payment_amount"
                                    value="<?php echo $net_salary + $total_award; ?>"
                                    class="payment_amount form-control">
                                <!-- Hidden Employee Id -->
                                <input type="hidden" id="user_id" name="user_id"
                                    value="<?php echo $employee_info->user_id; ?>" class="salary form-control">
                                <input type="hidden" name="payment_month" value="<?php
                            if (!empty($payment_month)) {
                                echo $payment_month;
                            }
                            ?>" class="salary form-control">
                                <div class="">
                                    <!-- Payment Type -->
                                    <label class="control-label">Payment Method <span class="required"> *</span></label>
                                    <select name="payment_type" class="form-control "
                                        onchange="get_payment_value(this.value)" required>
                                        <option value="">Select Payment Method</option>
                                        <?php
                                 
                                    if (!empty($all_payment_method)) {
                                        foreach ($all_payment_method as $v_payment_method) {
                                            ?>
                                        <option<?php
                                            if (!empty($check_salary_payment->payment_type)) {
                                                echo $check_salary_payment->payment_type == $v_payment_method->payment_methods_id ? 'selected' : '';
                                            }
                                            ?> value="<?= $v_payment_method->id; ?>">
                                            <?= $v_payment_method->name; ?></option>
                                            <?php }
                                    } ?>
                                    </select>
                                </div><!-- Payment Type -->
                                <div class="">
                                    <label class="control-label">Comments </label>
                                    <input type="text" name="comments" value="<?php
                                if (!empty($check_salary_payment->comments)) {
                                    echo $check_salary_payment->comments;
                                }
                                ?>" class=" form-control">
                                </div>
<!--
                                <div class="mb-lg">
                                    <label class="pull-left control-label">deduct from default account
                                        <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top"
                                            title="will be deduct into account"></i>
                                    </label>
                                    <div class="pull-right">
                                        <div class="checkbox c-checkbox">
                                            <label>
                                                <input type="checkbox" class="custom-checkbox" checked id="use_postmark"
                                                    name="deduct_from_account">
                                                <span class="fa fa-check"></span></label>
                                        </div>

                                    </div>
                                </div>
-->

                                <div class="mb-lg" id="postmark_config"
                                    <?php echo (empty($check_salary_payment->account_id)) ? 'style="display:block"' : '' ?>>
                                    <label class="control-label">Payment Account <span class="required"> *</span></label>
                                    <div class="">
                                        <select name="account_id" style="width:100%;" class="form-control select_box" required>
                                        <option value="">Select Payment Account</option>
                                            <?php
                                      
                                        if (!empty($account_info)) {
                                            foreach ($account_info as $v_account) : ?>
                                            <option value="<?= $v_account->id ?>"
                                               >
                                                <?= $v_account->account_name ?></option>
                                            <?php endforeach;
                                        }
                                        ?>
                                        </select>
                                    </div>
                                  
                                </div>
                                <div class="form-group mt-lg">
                                    <div class="col-sm-5">
                                        <button type="submit" name="sbtn" value="1"
                                            class="btn btn-primary btn-block">update
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
       </form>

 <!-- Table -->

 
 <div class="col-sm-9 print_width">

         <div class="card">
                            <!-- Default panel contents -->
                            <div class="card-header"><strong>Payment History For <?php echo $employee_info->user->name ?></strong> </div>
                            <div class="card-body">     
                    <!-- Table -->
                   <div class="table-responsive">
                <table class="table table-striped "id="table-1">
                        <thead>
                        <tr>
                            <th>Month</th>
                            <th>Date</th>
                            <th>Gross Salary</th>
                            <th>Total Deduction</th>
                            <th>Net Salary</th>
                            <th>Fine Deduction</th>
                            <th>Amount</th>
                            <th>Details</th>
                        </tr>
                        </thead>
                        <tbody>

                      <?php
                      
                       $total_paid_amount=0;
                    if (!empty($check_existing_payment)):
                  
                        foreach ($check_existing_payment as $row): 

?>
                        <tr>
                           
                            <td> <?php echo date('F Y', strtotime($row->payment_month)); ?></td>
                            
                            <td><?php echo date('d/m/ Y', strtotime($row->paid_date)); ?>  </td>

                              <?php
                 
                   $ttl_deduction =App\Models\Payroll\SalaryPaymentDeduction::all()->where('salary_payment_id', $row->id)->sum('salary_payment_deduction_value');;;         
                    $ttl_allowance  = App\Models\Payroll\SalaryPaymentAllowance::all()->where('salary_payment_id', $row->id)->sum('salary_payment_allowance_value');;
                     $total_salary = App\Models\Payroll\ SalaryPaymentDetails::where('salary_payment_id', $row->id)->where('salary_payment_details_label', '!=', 'Salary Grade')->sum('salary_payment_details_value');
                       $total_paid_amount= $total_salary +  $ttl_allowance;        

?>
                            <td><?php echo  number_format($total_paid_amount,2) ;;?></td>
                                 <td><?php echo  number_format($ttl_deduction,2) ;;?></td>
                               <td><?php echo  number_format($total_paid_amount - $ttl_deduction,2) ;;?></td>
                               
                             <?php 
  $fine_deduction = 0;
if (!empty($row->fine_deduction)) {
                        $fine_deduction = $row->fine_deduction;
                    } 
?>
                       <td><?php echo  number_format( $fine_deduction,2) ;;?></td>
  <td><?php echo  number_format(($total_paid_amount - $ttl_deduction)-$fine_deduction,2) ;;?></td>   
                            
                          
                            <td>

                                    <div class="form-inline">
                   

                      <div class = "input-group"> 
                      
                                <a href="#" class="btn btn-info btn-xs" title="View" data-toggle="modal" data-target="#appFormModal"  data-id="{{ $row->id }}" data-type="template"   onclick="model({{ $row->id }},'payment')">View Payment Details</a>
                                               
                    </div>&nbsp
                    </div>
                                    
                            </td>
                        </tr>
                       
                        <?php endforeach; ?>
                        <?php endif; ?>
                        </tbody>
                    </table>
</div>
</div>
        </div>
    </div>
                </div><!--************ Payment History End***********-->
                      
<?php endif; ?>

<!-- discount Modal -->
<div class="modal inmodal show" id="appFormModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
    </div>
</div>
</div>
</div>
@endsection



@section('scripts')
<script type="text/javascript">
    function model(id, type) {

        let url = '{{ route("salary_template.show", ":id") }}';
        url = url.replace(':id', id)
        var month = "<?php echo $payment_month; ?>";
        $.ajax({
            type: 'GET',
            url: url,
            data: {
                'type': type,
                 'month': month,
            },
            cache: false,
            async: true,
            success: function(data) {
                //alert(data);
                $('.modal-dialog').html(data);
            },
            error: function(error) {
                $('#appFormModal').modal('toggle');

            }
        });

    }
    </script>

<script type="text/javascript">
function payment_history(payment_history) {
    var printContents = document.getElementById(payment_history).innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
}
</script>
<script type="text/javascript">
$(document).ready(function() {
    var award = 0;
    $(".award").each(function() {
        award += parseFloat(this.value);
    });
    $("#total_award").val(award);
});
$(document).on("change", function() {
    var fine = 0;
    fine = $("#fine_deduction").val();
    var total_award = $("#total_award").val();
    var net_salary = $("#net_salary").val();
    var sub_tatal = parseFloat(net_salary) + parseFloat(total_award);
    var total = sub_tatal - fine;
    $(".payment_amount").val(total);
});
</script>
@endsection