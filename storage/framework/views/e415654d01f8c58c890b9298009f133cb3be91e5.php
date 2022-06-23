<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="formModal">Assign Inventory Serial No </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
      <?php echo e(Form::open(['route' => 'reference_inv.save'])); ?>

             <?php echo method_field('POST'); ?>
        <div class="modal-body">
            <p><strong>Make sure you enter valid information</strong> .</p>
                     
                 <div class="form-group">
                <label class="col-lg-6 col-form-label">Serial No</label>

                <div class="col-lg-12">
                    
               <input type="text" name="reference" value="" required class="form-control">
                <input type="hidden" name="id" value="<?php echo e($id); ?>" required class="form-control">
                </div>
            </div>

          


        </div>
        <div class="modal-footer bg-whitesmoke br">
            <button type="submit" class="btn btn-primary">Save</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        <?php echo Form::close(); ?>

    </div>
</div><?php /**PATH /home/admin/web/del.co.tz/public_html/resources/views/inventory/addreference.blade.php ENDPATH**/ ?>