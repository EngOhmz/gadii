<div class="modal fade" role="dialog" id="editPermissionModal" aria-labelledby="editPermissionModal"
     data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content" id="modal-content">
            <?php echo e(Form::open(['route' => ['designations.update', 1]])); ?>

            <?php echo method_field('PUT'); ?>
            <div class="modal-header p-2 px-3">
                <h6 class="modal-title">EDIT DESIGNATION</h6>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control" name="name" id="p-name_">
                </div>
                  <div class="form-group">
                    <label class="">Department Name</label>
                    <select name="department_id" class="form-control"  id="p-dep_"  required>
                   <option value="">Select Department</option>
                 <?php if(!empty($department)): ?>
                 <?php $__currentLoopData = $department; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
               <option value="<?php echo e($row->id); ?>"><?php echo e($row->name); ?></option>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>
</select>
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
<?php /**PATH /home/admin/web/del.co.tz/public_html/resources/views/manage/designation/edit.blade.php ENDPATH**/ ?>