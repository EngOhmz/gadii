<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="formModal">Tyre list</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
     
        <div class="modal-body">
           
                                            <div class="table-responsive">
                                                
                                            <table class="table table-bordered" id="service">
                                                <thead>
                                                    <tr>
                                                      <th>#</th>
                                                        <th>Tyre</th>
                                                          <th>Tyre Position</th>
                                                       
                                                    </tr>
                                                </thead>
                                                <tbody >
                                              
            
 <?php if(!@empty($tyre)): ?>
                                            <?php $__currentLoopData = $tyre; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr class="gradeA even" role="row">
                                                <th><?php echo e($loop->iteration); ?></th>
                                                <td><?php echo e($row->tyre->reference); ?></td>
                                                <td><?php echo e($row->position); ?></td>
                                               
                                            </tr>
                                          
  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                            <?php endif; ?>
                                                </tbody>
                                               
                                            </table>
                                         

                                    
</div>
</div>
        <div class="modal-footer bg-whitesmoke br">
         
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        <?php echo Form::close(); ?>

    </div>
</div><?php /**PATH /home/admin/web/del.co.tz/public_html/resources/views/tyre/tyre_list.blade.php ENDPATH**/ ?>