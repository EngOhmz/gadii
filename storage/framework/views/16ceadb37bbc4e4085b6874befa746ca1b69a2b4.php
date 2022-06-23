<div class="modal fade" role="dialog" id="editRoleModal" aria-labelledby="editRoleModal"
     data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content" id="modal-content">
            <?php echo e(Form::open(['route' => ['roles.update', 1]])); ?>

            <?php echo method_field('PUT'); ?>
            <div class="modal-header p-2 px-2">
                <h4 class="modal-title">EDIT PERMISSION</h4>
            </div>
            <div class="modal-body p-3">
                <div class="form-group">
                    <label class="control-label">Role Name </label>
                    <input type="text" class="form-control" name="slug" id="r-slug_">
                </div>
                <input type="hidden" name="id" id="r-id_">
            </div>
            <div class="modal-footer p-0">
                <div class="p-2">
                    <button type="button" class="btn btn-sm btn-outline-warning px-3 mr-1" data-dismiss="modal">Close
                    </button>
                    <?php echo Form::submit('Save', ['class' => 'btn btn-sm btn-outline-success px-3']); ?>

                </div>
            </div>
            <?php echo Form::close(); ?>

        </div>
    </div>
</div>
<?php /**PATH /home/admin/web/del.co.tz/public_html/resources/views/manage/role/edit.blade.php ENDPATH**/ ?>