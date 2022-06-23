<div class="modal fade" role="dialog" id="addRoleModal" aria-labelledby="addPermissionModal"
     data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content" id="modal-content">
            <?php echo e(Form::open(['route' => 'roles.store'])); ?>

            <?php echo method_field('POST'); ?>
            <div class="modal-header py-2 px-2">
                <h4 class="modal-title">ADD ROLE</h4>
            </div>
            <div class="modal-body p-3">
                <div class="form-group">
                    <label class="control-label">Role Name</label>
                    <input type="text" class="form-control" name="slug" id="p-slug_">
                </div>
            </div>
            <div class="modal-footer p-0">
                <div class="p-2">
                    <button type="button" class="btn btn-xs btn-outline-warning mr-1 px-3" data-dismiss="modal">Close</button>
                    <?php echo Form::submit('Save', ['class' => 'btn btn-xs btn-outline-success px-3']); ?>

                </div>
            </div>
            <?php echo Form::close(); ?>

        </div>
    </div>

</div>
<?php /**PATH /home/admin/web/del.co.tz/public_html/resources/views/manage/role/add.blade.php ENDPATH**/ ?>