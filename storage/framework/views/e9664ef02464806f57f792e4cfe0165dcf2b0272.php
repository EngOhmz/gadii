<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="formModal">Assign Truck</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <?php echo e(Form::model($id, array('route' => array('purchase_tyre.save'), 'method' => 'POST'))); ?>

        <div class="modal-body">
            <p><strong>Make sure you enter valid information</strong> .</p>
                     
                 <div class="form-group">
                <label class="col-lg-6 col-form-label">Tyre</label>

                <div class="col-lg-12">
                    <select name="tyre"
                    class="form-control" required>
                    <option value="">Select Item</option>
                    <?php $__currentLoopData = $name; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                    <option value="<?php echo e($n->id); ?>"><?php echo e($n->reference); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>

                <input type="hidden" name="id" value="<?php echo e($id); ?>" required class="form-control">
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-6 col-form-label">Mechanical</label>

                <div class="col-lg-12">
                    <select name="staff"
                    class="form-control" required>
                    <option value="">Select</option>
                    <?php $__currentLoopData = $staff; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                    <option value="<?php echo e($s->id); ?>"><?php echo e($s->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                    
                </div>
            </div>
           
    <div class="form-group">
                <label class="col-lg-6 col-form-label">Tyre Position</label>

                <div class="col-lg-12">
                    <select name="position"
                    class="form-control" required>
                    <option value="">Select</option>
                    <option value="Diff">Diff</option>
                    <option value="Rear">Rear</option>
                     <option value="Trailer">Trailer</option>
                </select>
                    
                </div>
            </div>
      <div class="form-group">
                <label class="col-lg-6 col-form-label">km reading</label>

                <div class="col-lg-12">
                 <input type="text" name="reading" value=""   class="form-control"  required>
                    
                </div>
            </div>

        </div>
        <div class="modal-footer bg-whitesmoke br">
            <button type="submit" class="btn btn-primary">Save</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        <?php echo Form::close(); ?>

    </div>
</div><?php /**PATH /home/admin/web/gaki.ema.co.tz/public_html/resources/views/tyre/addtyre.blade.php ENDPATH**/ ?>