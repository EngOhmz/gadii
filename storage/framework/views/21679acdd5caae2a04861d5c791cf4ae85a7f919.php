

           

<div class="" id="test">
     <div class="form-group" >
                <label class="col-lg-6 col-form-label">Truck </label>

                <div class="col-lg-12">
                    <select class="form-control truck_id" name="truck_id"  id="truck" required>
                                                      
                                                        <option value="">Select Truck</option>
                                                                        <?php if(!empty($truck)): ?>
                                                        <?php $__currentLoopData = $truck; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                        <option <?php if(isset($data)): ?>
                                                            <?php echo e($data->truck_id == $row->id  ? 'selected' : ''); ?>

                                                            <?php endif; ?> value="<?php echo e($row->id); ?>"><?php echo e($row->reg_no); ?> </option>

                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php endif; ?>


                                                    </select>
                </div>
            </div>

 <div class="form-group">
                <label class="col-lg-6 col-form-label">Driver</label>

                <div class="col-lg-12">
                    <select class="form-control driver_id" name="driver_id" id="driver" required>
                                                      
                                                        <option value="">Select Driver</option>
                                                       
                                                         <?php if(!empty($driver)): ?>
                                                        <?php $__currentLoopData = $driver; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                        <option <?php if(isset($data)): ?>
                                                            <?php echo e($data->driver_id == $row->id  ? 'selected' : ''); ?>

                                                            <?php endif; ?> value="<?php echo e($row->id); ?>"><?php echo e($row->driver_name); ?> </option>

                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php endif; ?>

                                                    </select>
                </div>
            </div>
        

        </div>
      
<?php /**PATH /home/admin/web/gaki.ema.co.tz/public_html/resources/views/order_movement/addtruck.blade.php ENDPATH**/ ?>