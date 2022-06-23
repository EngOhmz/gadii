<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="formModal">Order Collection</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <?php echo e(Form::model($id, array('route' => array('order_movement.update', $id), 'method' => 'PUT'))); ?>

        <div class="modal-body" id="modal_body">

              <div class="form-group">
                <label class="col-lg-6 col-form-label">Transport Type </label>

                <div class="col-lg-12">
                    <select class="form-control type" name="owner_type" id="type" required>
                                                   <option value="">Select</option>
                                            <option <?php if(isset($data)): ?>
                                                   <?php echo e($data->type == 'owned'  ? 'selected' : ''); ?>

                                                   <?php endif; ?> value="owned">From Company</option>
                                                   <option <?php if(isset($data)): ?>
                                                   <?php echo e($data->type == 'non_owned'  ? 'selected' : ''); ?>

                                                   <?php endif; ?> value="non_owned">From Third Party Company</option>

                                                 </select>
                </div>
            </div>
<div class="" id="test">
     <div class="form-group">
                <label class="col-lg-6 col-form-label">Truck </label>

                <div class="col-lg-12">
                    <select class="form-control truck_id" name="truck_id"  id="truck" required>
                                                      
                                                        <option value="">Select Truck</option>
                                                     

                                                    </select>
                </div>
            </div>

        
      <div class="form-group">
                <label class="col-lg-6 col-form-label">Driver</label>

                <div class="col-lg-12">
                    <select class="form-control driver_id" name="driver_id" id="driver" required>
                                                      
                                                        <option value="">Select Driver</option>
                                                       

                                                    </select>
                </div>
            </div>
</div>
            <div class="form-group">
                <label class="col-lg-6 col-form-label">Description</label>

                <div class="col-lg-12">
                    <input type="text" name="notes" value="" required class="form-control">
                    
                </div>
            </div>
          
                 <div class="form-group">
                <label class="col-lg-6 col-form-label">Collection Date</label>

                <div class="col-lg-12">
                    <input type="date" name="collection_date" value="" required class="form-control">
                    <input type="hidden" name="type" value="collection" required class="form-control">
                    <input type="hidden" name="id" value="<?php echo e($id); ?>" required class="form-control" id="collection">
</div>
            </div>


        </div>
        <div class="modal-footer bg-whitesmoke br">
            <button type="submit" class="btn btn-primary">Save</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        <?php echo Form::close(); ?>

    </div>
</div><?php /**PATH /home/admin/web/gaki.ema.co.tz/public_html/resources/views/order_movement/addcollection.blade.php ENDPATH**/ ?>