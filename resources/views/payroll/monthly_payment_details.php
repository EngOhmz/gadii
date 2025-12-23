<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h2 class="modal-title" id="formModal" >Employee Payment Details</h2>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
       
        <div class="modal-body">
          <?php
            $total_advance = 0;
                                        if (!empty($advance_salary)) {
                                            foreach ($advance_salary as  $v_advance) {                                            
                                                    $total_advance += $v_advance->advance_amount;                                               
                                            }
                                        }
                                       $total_award = 0;
                                        if (!empty($award_info)) {
                                            foreach ($award_info as  $v_award_info) {
                                                    $total_award += $v_award_info->award_amount;
                                            }
                                        }
                                     $total_amount=0;
                                        if (!empty($overtime_info)) {
                                            foreach ($overtime_info as  $v_overtime) {                                    
                                                    $total_amount += $v_overtime->overtime_amount;
                                                
                                            }
                                        }

                                              $total_loan = 0;
                                        if (!empty($loan_info)) {
                                            foreach ($loan_info as  $v_loan) {                                            
                                                    $total_loan += $v_loan->loan_amount;                                               
                                            }
                                        }

?>

            <table class="table datatable-basic table-borderless">
                                   <tr><td><strong>Employee Name   </strong></td><td><?php echo  $salary_grade_info->user->name; ?></td></tr>                                                                                                  
                                  <tr><td><strong>Department  </strong></td><td><?php echo $employee_info->department->name; ?></td> </tr>

                   </table>

       
<br>
   <div class="">                            
                       <h5> SALARY DETAILS</h5>
                    </div>
<hr>

  <table class="table datatable-basic table-borderless">
                                   <tr><td><strong>Salary Month    </strong></td><td><?php echo date('F Y', strtotime($payment_month)); ?></td></tr>  
                                  <tr><td><strong>Paid Date   </strong></td><td><?php echo date('d/m/Y', strtotime($salary_info->paid_date)); ?></td></tr>
                                  <tr><td><strong>Salary Grade </strong></td><td><?php echo  $salary_grade_info->salaryTemplates->salary_grade; ?></td> </tr>
                              <tr><td><strong>Basic Salary </strong></td><td><?php echo number_format( $salary_grade_info->salaryTemplates->basic_salary,2); ?></td> </tr>
                       <?php
               if($total_amount > 0){ ?>
                    <tr><td><strong>Overtime</strong></td><td><?php echo number_format($total_amount ,2); ?></td> </tr>
                     <?php } ?>
 <?php
               if($total_award > 0){ ?>
                              <tr><td><strong>Award</strong></td><td><?php echo number_format($total_award ,2); ?></td> </tr>
                 <?php } ?>
                   </table>

    
<hr>
<div class="row">
<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="panel panel-custom">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h5> ALLOWANCES</h5><br>
                        </div>
                    </div>
                    
             <table class="table datatable-basic table-borderless">
             
                        <?php
                       $total_salary = 0;
                        if (!empty($salary_allowance_info[0])):foreach ($salary_allowance_info as $v_allowance_info):
                            ?>
                         <tr>
                         <td><strong><?php echo $v_allowance_info->salary_payment_allowance_label; ?></td>
                          <td><?php echo number_format($v_allowance_info->salary_payment_allowance_value, 2) ?></td>
                                       
                            </tr>
                            <?php $total_salary += $v_allowance_info->salary_payment_allowance_value; ?>
                        <?php endforeach; ?>
                       <?php else : ?>
                             <p class="form-control-static"><strong> NO DATA FOUND</strong></p>
                        <?php endif; ?>
</table>
                </div>
            </div><!-- ********************Allowance End ******************-->

<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="panel panel-custom">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h5> DEDUCTIONS</h5><br>
                        </div>
                    </div>
                     <table class="table datatable-basic table-borderless">
             
                        <?php
                       $total_deduction = 0;
                        if (!empty($salary_deduction_info[0])):foreach ($salary_deduction_info as $v_deduction_info):
                            ?>
                         <tr>
                         <td><strong><?php echo $v_deduction_info->salary_payment_deduction_label; ?></td>
                          <td><?php echo number_format($v_deduction_info->salary_payment_deduction_value, 2) ?></td>                                       
                            </tr>
                            <?php $total_deduction += $v_deduction_info->salary_payment_deduction_value; ?>
                        <?php endforeach; ?>

                    
                    <?php
               if($salary_info->fine_deduction > 0){ ?>
                        <tr>
                         <td><strong>Fine Deduction </td>
                          <td><?php echo number_format($salary_info->fine_deduction  ,2); ?></td>                                       
                            </tr>
                          
                <?php } ?>
                        <?php else : ?>
                             <p class="form-control-static"><strong> NO DATA FOUND</strong></p>
                        <?php endif; ?>
                    </table>
                </div>
            </div><!-- ********************Deduction End  ******************-->

         <br>

              <div class="col-lg-12" style="text-align:center">
               <div class="panel panel-custom">
                    <div class="panel-heading">
                        <div class="panel-title">  <br>
                            <h5> TOTAL SALARY DETAILS</h5><br>
                        </div>
                    </div>
                      <table class="table datatable-basic table-borderless">
                                   <tr><td><strong>Basic Salary  </strong></td><td><?php echo number_format( $salary_grade_info->salaryTemplates->basic_salary , 2) ?></td></tr>                                                                                                  
                                  <tr><td><strong>Total Allowances   </strong></td><td><?php echo number_format($total_salary + $total_award + $total_amount, 2) ?></td> </tr>                                     
                              <tr><td><strong>Gross Salary  </strong></td><td><?php echo number_format($total_salary +  $total_award + $total_amount + $salary_grade_info->salaryTemplates->basic_salary, 2) ?></td> </tr>                                      
                              <tr><td><strong>Total Deductions  </strong></td><td><?php echo number_format( $total_deduction + $salary_info->fine_deduction, 2) ?></td> </tr>                                       
          <tr><td><strong>Net Salary   </strong></td><td><?php echo number_format(($total_salary +   $total_award + $total_amount + $salary_grade_info->salaryTemplates->basic_salary)-($total_deduction + $salary_info->fine_deduction)  , 2) ?></td> </tr>                                      
                            
                       <?php
                      if(!empty($salary_info)) {
                        ?>
                       <tr><td><strong>Payment Account </strong></td><td><?php echo $salary_info->account->account_name ?></td> </tr>    
                                 <tr><td><strong>Payment Method </strong><td><?php echo $salary_info->method->name ?></td></tr>                                       
                            
                          <?php } ?>
                   </table>
                </div>
                </div>
           

</div>
        </div>
        <div class="modal-footer ">
         
         <button class="btn btn-link" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i> Close</button>
        </div>
      
    </div>
</div>