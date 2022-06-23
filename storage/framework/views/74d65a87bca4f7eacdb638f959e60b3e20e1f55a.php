<?php $__env->startSection('content'); ?>
<section class="section">
    <div class="section-body">
        <?php echo $__env->make('layouts.alerts.message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Edit User</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">

                            <a href="<?php echo e(route('users.index')); ?>" class="btn btn-secondary btn-xs px-4">
                                <i class="fa fa-arrow-alt-circle-left"></i>
                                Back
                            </a>


                        </ul><br>
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade <?php if(empty($id)): ?> active show <?php endif; ?>" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">
                                <?php $__currentLoopData = $user; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $users): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php echo e(Form::model($users, array('route' => array('users.update', $users->id), 'method' => 'PUT'))); ?>

            <div class="ibox-content p-0 px-3 pt-2">
                <div class="row">
                    <div class="form-group col-lg-12 col-md-12 col-sm-12">
                        <label class="control-label">Full Name</label>
                        <input type="text" class="form-control" name="name" id="name" value="<?php echo e($users->name); ?>">
                    </div>
                 
                </div>
                <div class="row">
                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                        <label class="control-label">User Name</label>
                        <input type="text" class="form-control" name="email" id="email" value="<?php echo e($users->email); ?>">
                    </div>
                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                        <label class="control-label">Address</label>
                         <input type="text" class="form-control" name="address" id="address" value="<?php echo e($users->address); ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                        <label class="control-label">Phone Number</label>
                        <input type="phone" class="form-control" name="phone" id="phone" value="<?php echo e($users->phone); ?>">
                    </div>
                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                        <label class="">Role </label>
                        <select class="form-control" name="role" >
                            <option value="" disabled selected>Choose option</option>
                            <?php if(isset($role)): ?>
                            <?php $__currentLoopData = $role; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $roles): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php if(isset($users)): ?>
                                                            <?php echo e($users->role == $roles->id  ? 'selected' : ''); ?>

                                                            <?php endif; ?>  <?php echo e($roles->id); ?>"><?php echo e($roles->slug); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>

       <div class="row">
                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                        <label class="control-label">Department</label>
                        <select  id="department_id" name="department_id" class="form-control department">
                                      <option ="">Select Department</option>
                                      <?php if(!empty($department)): ?>
                                                        <?php $__currentLoopData = $department; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                        <option <?php if(isset($users)): ?>
                                                            <?php echo e($users->department_id == $row->id  ? 'selected' : ''); ?>

                                                            <?php endif; ?> value="<?php echo e($row->id); ?>"><?php echo e($row->name); ?></option>

                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php endif; ?>
                                    </select>
                    </div>

 <?php if(!empty($users->designation_id)): ?>
                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                        <label class="">Designation </label>
                        <select id="designation_id" name="designation_id" class="form-control designation">
                                      <option>Select Designation</option>
                           <?php if(!empty($designation)): ?>
                                                        <?php $__currentLoopData = $designation; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                        <option <?php if(isset($users)): ?>
                                                            <?php echo e($users->designation_id == $row->id  ? 'selected' : ''); ?>

                                                            <?php endif; ?> value="<?php echo e($row->id); ?>"><?php echo e($row->name); ?></option>

                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php endif; ?>
                        </select>
                    </div>
             <?php else: ?>
                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                        <label class="">Designation </label>
                        <select id="designation_id" name="designation_id" class="form-control designation">
                                      <option>Select Designation</option>                         
                        </select>
                    </div>
             <?php endif; ?>

                </div>
            </div>
            <div class="ibox-footer">
                <div class="row justify-content-end mr-1">
                    <?php echo Form::submit('Save', ['class' => 'btn btn-sm btn-info px-5']); ?>

                </div>
            </div>
            <?php echo Form::close(); ?>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>



<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
$(document).on('click', '.edit_user_btn', function() {
    var id = $(this).data('id');
    var name = $(this).data('name');
    var slug = $(this).data('slug');
    var module = $(this).data('module');
    $('#id').val(id);
    $('#p-name_').val(name);
    $('#p-slug_').val(slug);
    $('#p-module_').val(module);
    $('#editPermissionModal').modal('show');
});
</script>

<script>
$(document).ready(function() {

    $(document).on('change', '.department', function() {
        var id = $(this).val();
        $.ajax({
            url: '<?php echo e(url("findDepartment")); ?>',
            type: "GET",
            data: {
                id: id
            },
            dataType: "json",
            success: function(response) {
                console.log(response);
                $("#designation_id").empty();
                $("#designation_id").append('<option value="">Select Designation</option>');
                $.each(response,function(key, value)
                {
                 
                    $("#designation_id").append('<option value=' + value.id+ '>' + value.name + '</option>');
                   
                });                      
               
            }

        });

    });






});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/admin/web/gaki.ema.co.tz/public_html/resources/views/manage/users/edit.blade.php ENDPATH**/ ?>