
    <div class="modal-content">
        <div class="modal-header">
            <h2 class="modal-title" id="formModal" >Salary Template Details</h2>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
       
        <div class="modal-body">

         <table class="table datatable-basic table-borderless">
                                   <tr><td><strong>Salary Grade  </strong></td><td><?php echo $salary_template_info->salary_grade ?></td></tr>                                                                                                  
                                  <tr><td><strong>Basic Salary   </strong></td><td><?php echo number_format($salary_template_info->basic_salary, 2) ?></td> </tr>
                   </table>
        
         
<hr><br>
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
                         <td><strong><?php echo $v_allowance_info->allowance_label; ?></td>
                          <td><?php echo number_format($v_allowance_info->allowance_value, 2) ?></td>
                                       
                            </tr>
                            <?php $total_salary += $v_allowance_info->allowance_value; ?>
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
                         <td><strong><?php echo $v_deduction_info->deduction_label; ?></td>
                          <td><?php echo number_format($v_deduction_info->deduction_value, 2) ?></td>
                                       
                            </tr>
                            <?php $total_deduction += $v_deduction_info->deduction_value; ?>
                        <?php endforeach; ?>
                         <?php else : ?>
                             <p class="form-control-static"><strong> NO DATA FOUND</strong></p>
                        <?php endif; ?>
</table>
                 
<br> 
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
                                   <tr><td><strong>Basic Salary  </strong></td><td><?php echo number_format($salary_template_info->basic_salary, 2) ?></td></tr>                                                                                                  
                                  <tr><td><strong>Total Allowances   </strong></td><td><?php echo number_format($total_salary, 2) ?></td> </tr>                                     
                              <tr><td><strong>Gross Salary  </strong></td><td><?php echo number_format($total_salary + $salary_template_info->basic_salary, 2) ?></td> </tr>                                      
                              <tr><td><strong>Total Deductions  </strong></td><td><?php echo number_format($total_deduction, 2) ?></td> </tr>                                       
                             <tr><td><strong>Net Salary   </strong></td><td><?php echo number_format(($total_salary + $salary_template_info->basic_salary)-$total_deduction  , 2) ?></td> </tr>                                      
                            </table>


                </div>
                </div>
           

</div>
        </div>
        <div class="modal-footer ">
         <button class="btn btn-link" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i> Close</button>
        </div>
      
    </div>
