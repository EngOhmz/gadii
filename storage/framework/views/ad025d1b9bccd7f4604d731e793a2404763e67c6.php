<div class="modal-dialog modal-lg" role="document">
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
                     
              

                <input type="hidden" name="id" value="<?php echo e($id); ?>" required class="form-control">

                                                <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Mechanical</label>
                                                    <div class="col-lg-4">
                                   <select name="staff"
                    class="form-control" required>
                    <option value="">Select</option>
                    <?php $__currentLoopData = $staff; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                    <option value="<?php echo e($s->id); ?>"><?php echo e($s->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                      
                                                    </div>
                                                    <label class="col-lg-2 col-form-label">km reading</label>
                                                    <div class="col-lg-4">
                                                     <input type="text" name="reading" value=""   class="form-control"  required>
               
                                                    </div>
                                                </div>

        
                                            <div class="table-responsive">
                                                <br>
                                              <h4 align="center">Choose Tyre</h4>
                                            <hr>



                                      <?php if(!empty($truck->due_diff >0 )): ?>
                                            <table class="table table-bordered" id="service">
                                                <thead>
                                                    <tr>
                                                        <th>Tyre</th>
                                                          <th>Tyre Position</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody >
                                              <?php   
                                    for($i = 0; $i < $truck->due_diff ; $i++){
                                       ?>
                                   <tr>
                                 <td> 
                        <select name="tyre_diff[]"  class="form-control" required>                   
                        <option value="">Select Item</option>
                        <?php $__currentLoopData = $name; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                    <option value="<?php echo e($n->id); ?>"><?php echo e($n->reference); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select></td>
                    <td>  <input type="text" name="diff_position[]" value="Diff"   class="form-control"  required readonly></td>
                 <td><button type="button" name="remove" class="btn btn-danger btn-xs remove_diff"><i class="fas fa-trash"></i></button></td>
  <?php  }    ?>

                                                </tbody>
                                               
                                            </table>
                                            <?php endif; ?>

                                      <?php if(!empty($truck->due_rear >0 )): ?>
                                            <table class="table table-bordered" id="service">
                                                <thead>
                                                    <tr>
                                                        <th>Tyre</th>
                                                          <th>Tyre Position</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody >
                                              <?php   
                                    for($i = 0; $i < $truck->due_rear ; $i++){
                                       ?>
                                   <tr>
                                 <td> 
                        <select name="tyre_rear[]"  class="form-control" required>                   
                        <option value="">Select Item</option>
                        <?php $__currentLoopData = $name; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                    <option value="<?php echo e($n->id); ?>"><?php echo e($n->reference); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select></td>
                    <td>  <input type="text" name="rear_position[]" value="Rear"   class="form-control"  required readonly></td>
                 <td><button type="button" name="remove" class="btn btn-danger btn-xs remove_rear"><i class="fas fa-trash"></i></button></td>
  <?php  }    ?>

                                                </tbody>
                                               
                                            </table>
                                            <?php endif; ?>
                                   


                                      <?php if(!empty($truck->due_trailer >0 )): ?>
                                            <table class="table table-bordered" id="service">
                                                <thead>
                                                    <tr>
                                                        <th>Tyre</th>
                                                          <th>Tyre Position</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody >
                                              <?php   
                                    for($i = 0; $i < $truck->due_trailer ; $i++){
                                       ?>
                                   <tr>
                                 <td> 
                        <select name="tyre_trailer[]"  class="form-control" required>                   
                        <option value="">Select Item</option>
                        <?php $__currentLoopData = $name; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                    <option value="<?php echo e($n->id); ?>"><?php echo e($n->reference); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select></td>
                    <td>  <input type="text" name="trailer_position[]" value="Trailer"   class="form-control"  required readonly></td>
                 <td><button type="button" name="remove" class="btn btn-danger btn-xs remove_trailer"><i class="fas fa-trash"></i></button></td>
  <?php  }    ?>

                                                </tbody>
                                               
                                            </table>
                                            <?php endif; ?>
                                    

        </div>

</div>
        <div class="modal-footer bg-whitesmoke br">
            <button type="submit" class="btn btn-primary">Save</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        <?php echo Form::close(); ?>

    </div>
</div><?php /**PATH /home/admin/web/del.co.tz/public_html/resources/views/tyre/addtyre.blade.php ENDPATH**/ ?>