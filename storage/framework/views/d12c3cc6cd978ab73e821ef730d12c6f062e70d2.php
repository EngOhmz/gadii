<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="formModal">Assign Driver</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
           <?php echo e(Form::open(['url' => url('save_driver')])); ?>

       <?php echo method_field('POST'); ?>
            <?php echo csrf_field(); ?>
        <div class="modal-body">

            <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">


                                             
 
                                                <div class="form-group row"><label class="col-lg-2 col-form-label">Driver </label>
                                                   
            
                                                <div class="col-lg-8">
                                                    <select class="form-control m-b" name="driver" required>
                                                        <option value="">Select
                                                        </option>
                                                        <?php if(!empty($driver)): ?>
                                                        <?php $__currentLoopData = $driver; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($row->id); ?>" ><?php echo e($row->driver_name); ?> </option>

                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php endif; ?>
                                                    </select>
            
                                                </div>
                                            </div>

                       
                   <input type="hidden" name="id" required
                                                            placeholder=""
                                                            value="<?php echo e($id); ?>"
                                                            class="form-control">
               
              </div>
</div>
                                                    </div>


        </div>
        <div class="modal-footer bg-whitesmoke br">
            <button type="submit" class="btn btn-primary" id="save">Save</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>


       </form>


    </div>
</div>


<?php /**PATH /home/admin/web/del.co.tz/public_html/resources/views/truck/adddriver.blade.php ENDPATH**/ ?>