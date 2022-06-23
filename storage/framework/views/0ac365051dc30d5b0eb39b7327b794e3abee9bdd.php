<?php $__env->startSection('content'); ?>
<section class="section">
    <div class="section-body">
        
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                    <h3 class="text-uppercase"><?php echo e($role->slug); ?> ( Role ) - Permissions</h3>
                <div class="ibox-tools text-white">
                    <a href="<?php echo e(route('roles.index')); ?>" class="btn btn-outline-info btn-xs px-4"><i
                            class="fa fa-arrow-circle-left"></i> Back </a>
                </div>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">

                            <button type="button" class="btn btn-outline-info btn-xs px-4" data-toggle="modal"
                                data-target="#addRoleModal">
                                <i class="fa fa-plus-circle"></i>
                                Add
                            </button>


                        </ul>
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade <?php if(empty($id)): ?> active show <?php endif; ?>" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">
                                <div class="table-responsive">
                                <?php echo Form::open(['route' => 'roles.create']); ?>

                <?php echo method_field('GET'); ?>
                <table class="table table-sm table-bordered w-100" id="datatable">
                    <thead>
                    <tr>
                        <th>S/N</th>
                        <th>Module</th>
                        <th>CRUD</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php   $i = 1 ?>
                    <?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php $m = $module->slug  ?>
                  
                        <tr>
                            <td><?php echo e($i++); ?></td>
                            <td width="25%"><?php echo e($module->slug); ?></td>
                            <td>
                               <div class="row">
                               
                                    <?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php $p = $permission->slug  ?>
                                 
                                        <?php if($permission->sys_module_id == $module->id): ?>
                                            <?php if($role->hasAccess($permission->slug)): ?>
                                            <div class="col-md-4 col-sm-6">
                                                <label>
                                                    <input type="checkbox"
                                                        value="<?php echo e($permission->id); ?>"
                                                        name="permissions[]" checked>
                                                    <?php echo e($permission->slug); ?>

                                                </label>
                                            </div>
                                            <?php else: ?>
                                            <div class="col-md-4 col-sm-6">
                                                <label>
                                                    <input type="checkbox" value="<?php echo e($permission->id); ?>"
                                                        name="permissions[]">
                                                    <?php echo e($permission->slug); ?>

                                                </label>
                                            </div>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                  
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                               </div>
                            </td>
                        </tr>
            
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
                <input type="hidden" name="role_id" value="<?php echo e($role->id); ?>">
                <div class="row justify-content-end p-0 mr-1">
                    <div class="p-1">
                        <a href="<?php echo e(route('roles.index')); ?>" class="btn btn-outline-secondary btn-xs px-4"><i
                                class="fa fa-arrow-circle-left"></i> Back </a>
                        <?php echo Form::submit('Assign', ['class' => 'btn btn-outline-success btn-xs px-4']); ?>

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
</section>


<?php echo $__env->make('manage.role.add', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('manage.role.edit', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
$(document).on('click', '.edit_role_btn', function() {
    let id = $(this).data('id');
    let name = $(this).data('name');
    let slug = $(this).data('slug');
    console.log("here");
    $('#r-id_').val(id);
    $('#r-slug_').val(slug);
    $('#r-name_').val(name);
    $('#editRoleModal').modal('show');
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/admin/web/del.co.tz/public_html/resources/views/manage/role/assign.blade.php ENDPATH**/ ?>