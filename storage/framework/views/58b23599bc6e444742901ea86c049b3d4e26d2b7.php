<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="formModal">Mechanical Report </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
      <?php echo e(Form::open(['route' => 'maintainance.report'])); ?>

             <?php echo method_field('POST'); ?>
        <div class="modal-body">
            <p><strong>Make sure you enter valid information</strong> .</p>
                     
                 <a href="javascript:void(0);" id="add_more" class="addCF"><i  class="fa fa-plus"></i>&nbsp;Add  Item</a><br>
                                            <br>
                                            <div class="table-responsive">

                                            <table class="table table-bordered" id="inventory">
                                                <thead>
                                                    <tr>
                                                        <th>Inventory Item</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody >


                                                </tbody>
                                               

                                            </table>
</div>
 <input type="hidden" name="maintainance_id"    value="<?php echo e($id); ?>"     required />
                                                                
                                                             
                                                            

        </div>
        <div class="modal-footer bg-whitesmoke br">
            <button type="submit" class="btn btn-primary">Save</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        <?php echo Form::close(); ?>

    </div>
</div><?php /**PATH /home/admin/web/gaki.ema.co.tz/public_html/resources/views/inventory/addmaintainance.blade.php ENDPATH**/ ?>