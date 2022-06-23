<?php $__env->startSection('content'); ?>
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Employee Loan</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link <?php if(empty($id)): ?> active show <?php endif; ?>" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Employee Loan
                                    List</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php if(!empty($id)): ?> active show <?php endif; ?>" id="profile-tab2"
                                    data-toggle="tab" href="#profile2" role="tab" aria-controls="profile"
                                    aria-selected="false">New Employee Loan</a>
                            </li>

                        </ul>
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade <?php if(empty($id)): ?> active show <?php endif; ?>" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">
                                <div class="table-responsive">
                               
                                    <table class="table table-striped" id="table-1">
                                        <thead>
                                            <tr role="row">

                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Browser: activate to sort column ascending"
                                                    style="width: 208.531px;">#</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Name</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Loan Amount</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                       rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Start Return Month</th> 
                                                  <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                       rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Status</th> 

                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('approve-payment')): ?>
                                            <?php if(!@empty($employee_loan)): ?>
                                            <?php $__currentLoopData = $employee_loan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                               <tr class="gradeA even" role="row">
                                                <th><?php echo e($loop->iteration); ?></th>
                                                <td><?php echo e($row->user->name); ?></td>
                                                <td><?php echo e(number_format($row->loan_amount,2)); ?></td>
                                              <td><a href=""title="View" data-id="<?php echo e($row->id); ?>" data-type="loan"  onclick="model(<?php echo e($row->id); ?>,'loan')"  data-toggle="modal" data-target="#appFormModal">  <?php echo date('Y M', 
 strtotime($row->deduct_month)) ?></a></td>  

                                               <td>
                                               <?php if($row->status == '0'): ?> 
                                                    <span class="badge badge-warning badge-shadow">Pending </span>
                                                <?php elseif($row->status == '1'): ?> 
                                                    <span class="badge badge-success badge-shadow">Accepted </span>
                                                <?php elseif($row->status == '2'): ?> 
                                                   <span class="badge badge-danger badge-shadow">Rejected </span>
                                                  <?php elseif($row->status == '3'): ?> 
                                                   <span class="badge badge-info badge-shadow">Partially Paid </span>
                                                   <?php else: ?>
                                                  <span class="badge badge-success badge-shadow">Fully Paid </span>
                                                 <?php endif; ?>
                                               </td>
                                                      
                                                <td>
                                                  <?php if($row->status == '0'): ?> 
                                                    <a class="btn btn-xs btn-outline-info text-uppercase px-2 rounded"
                                                        href="<?php echo e(route("employee_loan.edit", $row->id)); ?>">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <a class="btn btn-xs btn-outline-danger text-uppercase px-2 rounded demo4"
                                                        href="<?php echo e(route("employee_loan.destroy", $row->id)); ?>">
                                                        <i class="fa fa-trash"></i>
                                                    </a>

                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('approve-payment')): ?>
                                     <a href="<?php echo e(route('employee_loan.approve',$row->id)); ?>" class="btn btn-success mr" onclick="return confirm('Are you sure you want to Approve?')"><i class="fa fa-thumbs-up"></i> Approve</a >   
                                       <a href="<?php echo e(route('employee_loan.reject',$row->id)); ?>" class="btn btn-danger mr" nclick="return confirm('Are you sure you want to Reject?')"><i class="fa fa-times"></i> Reject</a >   
                                                      <?php endif; ?> 
                             <?php endif; ?> 
                                                </td>
                                            </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                            <?php endif; ?>


                                           <?php else: ?>
                                                    <?php if(!@empty($user_employee_loan)): ?>
                                            <?php $__currentLoopData = $user_employee_loan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                          
                                            <tr class="gradeA even" role="row">
                                                <th><?php echo e($loop->iteration); ?></th>
                                                <td><?php echo e($row->user->name); ?></td>
                                                <td><?php echo e(number_format($row->loan_amount,2)); ?></td>
                                              <td><a href=""title="View" data-id="<?php echo e($row->id); ?>" data-type="loan"  onclick="model(<?php echo e($row->id); ?>,'loan')"  data-toggle="modal" data-target="#appFormModal">  <?php echo date('Y M', 
 strtotime($row->deduct_month)) ?></a></td>  

                                               <td>
                                               <?php if($row->status == '0'): ?> 
                                                    <span class="badge badge-warning badge-shadow">Pending </span>
                                                <?php elseif($row->status == '1'): ?> 
                                                    <span class="badge badge-success badge-shadow">Accepted </span>
                                                <?php elseif($row->status == '2'): ?> 
                                                   <span class="badge badge-danger badge-shadow">Rejected </span>
                                                  <?php elseif($row->status == '3'): ?> 
                                                   <span class="badge badge-info badge-shadow">Partially Paid </span>
                                                   <?php else: ?>
                                                  <span class="badge badge-success badge-shadow">Fully Paid </span>
                                                 <?php endif; ?>
                                               </td>
                                                      
                                                <td>
                                                  <?php if($row->status == '0'): ?> 
                                                    <a class="btn btn-xs btn-outline-info text-uppercase px-2 rounded"
                                                        href="<?php echo e(route("employee_loan.edit", $row->id)); ?>">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <a class="btn btn-xs btn-outline-danger text-uppercase px-2 rounded demo4"
                                                        href="<?php echo e(route("employee_loan.destroy", $row->id)); ?>">
                                                        <i class="fa fa-trash"></i>
                                                    </a>

                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('approve-payment')): ?>
                                     <a href="<?php echo e(route('employee_loan.approve',$row->id)); ?>" class="btn btn-success mr" onclick="return confirm('Are you sure you want to Approve?')"><i class="fa fa-thumbs-up"></i> Approve</a >   
                                       <a href="<?php echo e(route('employee_loan.reject',$row->id)); ?>" class="btn btn-danger mr" nclick="return confirm('Are you sure you want to Reject?')"><i class="fa fa-times"></i> Reject</a >   
                                                      <?php endif; ?> 
                             <?php endif; ?> 
                                                </td>
                                            </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                            <?php endif; ?>
   <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade <?php if(!empty($id)): ?> active show <?php endif; ?>" id="profile2" role="tabpanel"
                                aria-labelledby="profile-tab2">

                                <div class="card">
                                    <div class="card-header">
                                    <?php if(!empty($id)): ?>
                                            <h5>Edit Employee Loan</h5>
                                            <?php else: ?>
                                            <h5>Add New Employee Loan</h5>
                                            <?php endif; ?>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">
                                            <?php if(isset($id)): ?>
                                                    <?php echo e(Form::model($id, array('route' => array('employee_loan.update', $id), 'method' => 'PUT'))); ?>

                                                    <?php else: ?>
                                                    <?php echo e(Form::open(['route' => 'employee_loan.store'])); ?>

                                                    <?php echo method_field('POST'); ?>
                                                    <?php endif; ?>

                                                   <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('approve-payment')): ?>
                                                    <div class="form-group row"><label
                                                            class="col-lg-2 col-form-label">Employee <span class="required">*</span></label>

                                                        <div class="col-lg-10">
                                                         <select name="user_id" style="width: 100%" id="user_id" class="form-control user">
                            <option value="">Select Employee</option>
                            <?php if (!empty($all_employee)): ?>
                                <?php foreach ($all_employee as  $v_employee) : ?>
                                            <option value="<?php echo $v_employee->id; ?>"
                                                <?php
                                                if (!empty($data->user_id)) {
                                                    $user_id = $data->user_id;
                                                } 
                                                if (!empty($user_id)) {
                                                    echo $v_employee->id == $user_id ? 'selected' : '';
                                                }
                                                ?>><?php echo $v_employee->name  ?></option>
                                     
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                                                        </div>
                                                    </div>

                    <?php else: ?>
            <input type="hidden"   id="user_id" name="user_id"  class="form-control user"  value="<?php echo auth()->user()->id ?>">
            <?php endif; ?>


                                                    <div class="form-group row"><label
                                                            class="col-lg-2 col-form-label">Loan Amount <span class="required">*</span></label>

                                                        <div class="col-lg-10">
                                                            <input type="number" name="loan_amount"
                                                                value="<?php echo e(isset($data) ? $data->loan_amount : ''); ?>"
                                                                class="form-control amount"  placeholder="" required>
                                                        </div>
                                                     <div class=""> <p class="form-control-static" id="errors" style="text-align:center;color:red;"></p>   </div>   
                                                    </div>

                                                    <div class="form-group row"><label
                                                            class="col-lg-2 col-form-label">Amount Paid Per Month <span class="required">*</span></label>

                                                        <div class="col-lg-10">
                                                         <input type="number" name="paid_amount"
                                                                value="<?php echo e(isset($data) ? $data->paid_amount : ''); ?>"
                                                                class="form-control"  placeholder="" required>
                                                        </div>
                                                    </div>

                                                <div class="form-group row"><label
                                                            class="col-lg-2 col-form-label">Start Return Month <span class="required">*</span></label>

                                                        <div class="col-lg-10">
                                                              <input required type="month"  class="form-control monthyear" name="deduct_month" data-format="yyyy/mm/dd"  
                    value="<?php
                        if (!empty($data->deduct_month)) {
                            echo $data->deduct_month;
                        } 
                        ?>"
                     >
                                                                                                                    

</div>
                                                    </div>

                       

                                         <div class="form-group row"><label
                                                            class="col-lg-2 col-form-label">Reason</label>

                                                        <div class="col-lg-10">
                                                           <textarea name="reason" rows="4" class="form-control" id="field-1"
                          placeholder="Enter Your Reason"><?php
                    if (!empty($data->reason)) {
                        echo $data->reason;
                    }
                    ?></textarea>
                           
                                                        </div>
                                                    </div>

                             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('approve-payment')): ?>
                <input type="hidden" name="approve" value="yes"  class="form-control">
            <?php endif; ?>

                                                <div class="form-group row">
                                                    <div class="col-lg-offset-2 col-lg-12">
                                                        <?php if(!@empty($id)): ?>
                                                        <button class="btn btn-sm btn-primary float-right m-t-n-xs"
                                                            data-toggle="modal" data-target="#myModal"
                                                            type="submit"  id="save">Update</button>
                                                        <?php else: ?>
                                                        <button class="btn btn-sm btn-primary float-right m-t-n-xs"
                                                            type="submit"  id="save">Save</button>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                                <?php echo Form::close(); ?>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- discount Modal -->
<div class="modal inmodal show" id="appFormModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
    </div>
</div>
</div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>

<script src="<?php echo e(url('assets/js/plugins/sweetalert/sweetalert.min.js')); ?>"></script>

<script type="text/javascript">
    function model(id, type) {

        let url = '<?php echo e(route("salary_template.show", ":id")); ?>';
        url = url.replace(':id', id)
        $.ajax({
            type: 'GET',
            url: url,
            data: {
                'type': type,
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

<script>
$(document).ready(function() {

  

    $(document).on('change', '.amount', function() {
          var id = $(this).val();
        var user=$('#user_id').val();
        $.ajax({
            url: '<?php echo e(url("payroll/findLoan")); ?>',
            type: "GET",
            data: {
                id: id,
              user: user,
            },
            dataType: "json",
            success: function(data) {
              console.log(data);
            $("#errors").empty();
            $("#save").attr("disabled", false);
             if (data != '') {
           $("#errors").append(data);
           $("#save").attr("disabled", true);
} else {
  
}
            
       
            }

        });

    });





});
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/admin/web/app.ema.co.tz/public_html/resources/views/payroll/employee_loan.blade.php ENDPATH**/ ?>