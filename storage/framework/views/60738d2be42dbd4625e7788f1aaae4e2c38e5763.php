<div class="modal fade" role="dialog" id="editPermissionModal" aria-labelledby="editPermissionModal"
     data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content" id="modal-content">
            <?php echo e(Form::open(['route' => ['permissions.update', 1]])); ?>

            <?php echo method_field('PUT'); ?>
            <div class="modal-header p-2 px-3">
                <h6 class="modal-title">EDIT PERMISSION</h6>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Permission Tag </label>
                    <input type="text" class="form-control" name="slug" id="p-slug_">
                </div>
                <div class="form-group has-feedback">
                    <label>Module Name </label>
                    <select class="form-control" name="module_id" id="p-module_">
                        <option value="" disabled selected>Choose option</option>
                        <?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($module->id); ?>"><?php echo e($module->slug); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <span class="help-block"></span>
                </div>
                <input type="hidden" name="id" id="id">
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
<?php /**PATH /home/admin/web/gaki.ema.co.tz/public_html/resources/views/manage/permission/edit.blade.php ENDPATH**/ ?>