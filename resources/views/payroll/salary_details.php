<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h2 class="modal-title" id="formModal" >Employee Salary Details</h2>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
       
        <div class="modal-body">

         <div class="">                            
                        <p class="form-control-static" style="text-align:center;"><strong>Employee Name  : </strong><?php echo  $salary_grade_info->user->name; ?></p>
                    </div>
  <div class="">                            
                        <p class="form-control-static" style="text-align:center;"><strong>Department  : </strong><?php echo $employee_info->department->name; ?></p>
                    </div>
  <div class="">                            
                        <p class="form-control-static" style="text-align:center;"><strong>Designation  : </strong><?php echo $employee_info->designation->name ?></p>
                    </div>
           <div class="">                            
                        <p class="form-control-static" style="text-align:center;"><strong>Salary Grade  : </strong><?php echo  $salary_grade_info->salaryTemplates->salary_grade; ?></p>
                    </div>
                    <div class="">
                            <p class="form-control-static" style="text-align:center;"><strong>Basic Salary : </strong><?php echo number_format( $salary_grade_info->salaryTemplates->basic_salary,2); ?></p>    
                    </div>
<hr><br>
<div class="row">
<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="panel panel-custom">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h5> ALLOWANCES</h5><br>
                        </div>
                    </div>
                    <div class="panel-body">
                        <?php
                        $total_salary = 0;
                        if (!empty($salary_allowance_info[0])):foreach ($salary_allowance_info as $v_allowance_info):
                            ?>
                            <div class="">
                                <p class="form-control-static"><strong><?php echo $v_allowance_info->allowance_label; ?> : </strong><?php echo number_format($v_allowance_info->allowance_value, 2) ?></p>
                                       
                            </div>
                            <?php $total_salary += $v_allowance_info->allowance_value; ?>
                        <?php endforeach; ?>
                        <?php else : ?>
                             <p class="form-control-static"><strong> NO DATA FOUND</strong></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div><!-- ********************Allowance End ******************-->

<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="panel panel-custom">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h5> DEDUCTIONS</h5><br>
                        </div>
                    </div>
                    <div class="panel-body">
                        <?php
                       $total_deduction = 0;
                        if (!empty($salary_deduction_info[0])):foreach ($salary_deduction_info as $v_deduction_info):
                            ?>
                            <div class="">
                                <p class="form-control-static"><strong><?php echo $v_deduction_info->deduction_label; ?> : </strong><?php echo number_format($v_deduction_info->deduction_value, 2) ?></p>
                                       
                            </div>
                            <?php $total_deduction += $v_deduction_info->deduction_value; ?>
                        <?php endforeach; ?>
                        <?php else : ?>
                             <p class="form-control-static"><strong> NO DATA FOUND</strong></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div><!-- ********************Deduction End  ******************-->

         

              <div class="col-lg-12" style="text-align:center">
               <div class="panel panel-custom">
                    <div class="panel-heading">
                        <div class="panel-title">  <br>
                            <h5> TOTAL SALARY DETAILS</h5><br>
                        </div>
                    </div>
                    <div class="panel-body">
                       
                            <div class="">
                                <p class="form-control-static"><strong>Basic Salary  : </strong><?php echo number_format( $salary_grade_info->salaryTemplates->basic_salary, 2) ?></p>                                       
                            </div>
                          <div class="">
                                <p class="form-control-static"><strong>Total Allowances  : </strong><?php echo number_format($total_salary, 2) ?></p>                                       
                            </div>
                   <div class="">
                                <p class="form-control-static"><strong>Gross Salary  : </strong><?php echo number_format($total_salary +  $salary_grade_info->salaryTemplates->basic_salary, 2) ?></p>                                       
                            </div>
                <div class="">
                                <p class="form-control-static"><strong>Total Deductions  : </strong><?php echo number_format($total_deduction, 2) ?></p>                                       
                            </div>
                  <div class="">
                                <p class="form-control-static"><strong>Net Salary  : </strong><?php echo number_format(($total_salary +  $salary_grade_info->salaryTemplates->basic_salary)-$total_deduction  , 2) ?></p>                                       
                            </div>
                    </div>
                </div>
                </div>
           

</div>
        </div>
        <div class="modal-footer bg-whitesmoke br">
         
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      
    </div>
</div>