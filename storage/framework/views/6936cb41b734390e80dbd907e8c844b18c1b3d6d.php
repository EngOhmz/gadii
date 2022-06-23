<div class="modal fade" role="dialog" id="addPermissionModal" aria-labelledby="addPermissionModal"
     data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content" id="modal-content">
            <?php echo e(Form::open(['route' => 'permissions.store'])); ?>

            <?php echo method_field('POST'); ?>
            <div class="modal-header p-2 px-2">
                <h4 class="modal-title">ADD PERMISSION</h6>
            </div>
            <div class="modal-body p-3">
                <div class="form-group">
                    <label class="">Module Name </label>
                    <select class="form-control" name="module_id" required>
                        <option value="" disabled selected>Choose option</option>
                        <?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($module->id); ?>"><?php echo e($module->slug); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="form-group">
                    <label class="">Permission Tag </label>
                    <input type="text" class="form-control" name="slug" required>
                </div>
            </div>
            <div class="modal-footer p-0">
                <div class="p-2">
                    <button type="button" class="btn btn-xs btn-outline-warning mr-1 px-3" data-dismiss="modal">Close
                    </button>
                    <?php echo Form::submit('Save', ['class' => 'btn btn-xs btn-outline-success px-3']); ?>

                </div>
            </div>
            <?php echo Form::close(); ?>


        </div>
    </div>
</div>
<?php /**PATH /home/admin/web/app.ema.co.tz/public_html/resources/views/manage/permission/add.blade.php ENDPATH**/ ?>