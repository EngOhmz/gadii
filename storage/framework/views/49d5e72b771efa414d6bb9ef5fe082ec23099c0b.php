<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="formModal">
<?php if($type=='mechanical_maintainance'): ?>
Maintainance
<?php else: ?>
Service 
<?php endif; ?> 
Mechanical Report </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    
        <div class="modal-body">
            <p><strong>Make sure you enter valid information</strong> .</p>
                     
           

                                            <br>
                                            <div class="table-responsive">
                                                
                                            <table class="table table-bordered" id="service">
                                                <thead>
                                                    <tr>
                                                    <th>#</th>
                                                        <th>Service Type</th>
                                                       
                                                    </tr>
                                                </thead>
                                                <tbody >
                                                <?php $__currentLoopData = $item; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                              <tr class="gradeA even" role="row">
                                                <td><?php echo e($loop->iteration); ?></td>
                                                 <td><?php echo e($row->service->name); ?></td>
                                             </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </tbody>
                                               

                                            </table>

                                    
<br>
                               <table class="table table-bordered" id="recommedation">
                                                <thead>
                                                    <tr>
                                                   <th>#</th>
                                                        <th>Recommedation</th>
                                                        
                                                    </tr>
                                                </thead>
                                                <tbody >
                                               <?php $__currentLoopData = $notes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                              <tr class="gradeA even" role="row">
                                                <td><?php echo e($loop->iteration); ?></td>
                                                 <td><?php echo e($row->recommedation); ?></td>
                                             </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                </tbody>
                                               

                                            </table>
</div>
                                                  
                                                             
                                                            

        </div>
        <div class="modal-footer bg-whitesmoke br">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        <?php echo Form::close(); ?>

    </div>
</div><?php /**PATH /home/admin/web/del.co.tz/public_html/resources/views/inventory/viewreport.blade.php ENDPATH**/ ?>