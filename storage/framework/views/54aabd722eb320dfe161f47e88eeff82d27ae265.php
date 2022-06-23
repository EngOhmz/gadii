<?php $__env->startSection('content'); ?>
<section class="section">
    <div class="section-body">
        <?php echo $__env->make('layouts.alerts.message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Manage Designations</h4><br>

   <button type="button" class="btn btn-outline-info btn-xs px-4 pull-right"
                            data-toggle="modal" data-target="#addPermissionModal">
                        <i class="fa fa-plus-circle"></i>
                        Add
                    </button>
                    </div>
                    <div class="card-body">

                       
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade <?php if(empty($id)): ?> active show <?php endif; ?>" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="table-1">
                                    <thead>
                    <tr>
                        <th>S/N</th>
                        <th>Name</th>
                     <th>Department Name</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(isset($permissions)): ?>
                    <?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                   
                        <tr>
                            <th><?php echo e($loop->iteration); ?></th>
                            <td><?php echo e($permission->name); ?></td>
                            <td><?php echo e($permission->department->name); ?></td>
                            <td align="center">
                                <?php echo Form::open(['route' => ['designations.destroy', $permission->id], 'method' => 'delete']); ?>

                                <button type="button" class="btn btn-outline-info btn-xs edit_permission_btn"
                                        data-toggle="modal"
                                        data-id="<?php echo e($permission->id); ?>"
                                 data-name="<?php echo e($permission->name); ?>"
                                   data-department="<?php echo e($permission->department_id); ?>"
                                    <i class="fa fa-edit"></i> Edit
                                </button>
                                <?php echo e(Form::button('<i class="fas fa-trash"></i> Delete', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"])); ?>

                                <?php echo e(Form::close()); ?>

                            </td>
                        </tr>
                  
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                    </tbody>
                                    </table>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>


<?php echo $__env->make('manage.designation.add', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('manage.designation.edit', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
        $(document).on('click', '.edit_permission_btn', function () {
            var id = $(this).data('id');
            var name = $(this).data('name');
             var dep = $(this).data('department');
            $('#id').val(id);
            $('#p-name_').val(name);
             $('#p-dep_').val(dep);
            $('#editPermissionModal').modal('show');
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/admin/web/del.co.tz/public_html/resources/views/manage/designation/index.blade.php ENDPATH**/ ?>