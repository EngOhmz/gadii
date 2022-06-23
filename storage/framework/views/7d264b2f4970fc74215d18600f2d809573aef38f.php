<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="formModal">Order Offloading</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <?php echo e(Form::model($id, array('route' => array('order_movement.update', $id), 'method' => 'PUT'))); ?>

        <div class="modal-body">
        
            <p><strong>Make sure the offloaded order is the same as the order confirmed</strong> .</p>
             <ul>
                <?php
                   $data=App\Models\CargoLoading::find($id); 
                ?>
                <li>Truck : <?php echo e($data->truck->truck_name); ?> - <?php echo e($data->truck->reg_no); ?></li>
               <li>Driver Name: <?php echo e($data->driver->driver_name); ?> </li>
              <li>Route Name: From <?php echo e($data->route->from); ?> to  <?php echo e($data->route->to); ?> </li>
            </ul>


            <div class="form-group">
                <label class="col-lg-6 col-form-label">Description</label>

                <div class="col-lg-12">
                    <input type="text" name="notes" value="" required class="form-control">
                    
                </div>
            </div>
          
                 <div class="form-group">
                <label class="col-lg-6 col-form-label">Offloading Date</label>

                <div class="col-lg-12">
                    <input type="date" name="collection_date" value="" required class="form-control">
                    <input type="hidden" name="type" value="offloading" required class="form-control">
                </div>
            </div>


        </div>
        <div class="modal-footer bg-whitesmoke br">
            <button type="submit" class="btn btn-primary">Save</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        <?php echo Form::close(); ?>

    </div>
</div><?php /**PATH /home/admin/web/del.co.tz/public_html/resources/views/order_movement/addoffloading.blade.php ENDPATH**/ ?>