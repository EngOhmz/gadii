<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="formModal">Add Route</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
           <form id="addRouteForm" method="post" action="javascript:void(0)">
            <?php echo csrf_field(); ?>
        <div class="modal-body">
                        <div class="row">
                    <div class="form-group col-lg-12 col-md-12 col-sm-12">
                        <label class="control-label">Starting Point<span class="text-danger"> *</span></label>
                    <select class="form-control" name="from" required
                                                                id="from">
                                                                <option value="">Select</option>
                                                                <?php if(!empty($region)): ?>
                                                                <?php $__currentLoopData = $region; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                                <option value="<?php echo e($row->name); ?>"><?php echo e($row->name); ?> </option>

                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                <?php endif; ?>

                                                            </select>
                    </div>
                   
                       
                </div>
                <div class="row">
                    <div class="form-group col-lg-12 col-md-12 col-sm-12">
                        <label class="control-label">Destination Point <span class="text-danger">*</span></label>
                      <select class="form-control" name="to" required
                                                                id="to">
                                                                <option value="">Select</option>
                                                                <?php if(!empty($region)): ?>
                                                                <?php $__currentLoopData = $region; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                                <option value="<?php echo e($row->name); ?>"><?php echo e($row->name); ?> </option>

                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                <?php endif; ?>

                                                            </select>
                    </div>
                   
                </div>
         
                     <div class="row">
                    <div class="form-group col-lg-12 col-md-12 col-sm-12">
                        <label class="control-label">Distance <span class="text-danger">*</span></label>
                        <input type="number"  step="0.001" class="form-control" name="distance" id="distance" required>
                        <?php $__errorArgs = ['distance'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-danger">. <?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                
                    </div>

        </div>
        <div class="modal-footer bg-whitesmoke br">
            <button type="submit" class="btn btn-primary" id="save" onclick="saveRoute(this)" data-dismiss="modal">Save</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>


       </form>


    </div>
</div>

<script>    

</script> <?php /**PATH /home/admin/web/gaki.ema.co.tz/public_html/resources/views/pacel/addRoute.blade.php ENDPATH**/ ?>