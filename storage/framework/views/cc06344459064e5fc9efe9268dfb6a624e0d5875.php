<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="formModal">Invoice List</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

 <div class="modal-body">

            <div class="table-responsive">
                                    <table class="table table-striped" id="table-1">
                                        <thead>
                                            <tr>

                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 186.484px;">Reference</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 186.484px;">Client Name</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 186.484px;">Invoice Date</th>
                                             
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Due Amount</th>
                                                    
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Status</th>

                                              

                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if(!@empty($purchases)): ?>
                                            <?php $__currentLoopData = $purchases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr class="gradeA even" role="row">
                                                <td><a href="<?php echo e(route('invoice.details', $row->id)); ?>"><?php echo e($row->pacel_number); ?></a> </td>                                               
                                                <td>  <?php echo e($row->supplier->name); ?>   </td>
                                                <td><?php echo e($row->date); ?></td>
                                                <td><?php echo e(number_format($row->due_amount,2)); ?> <?php echo e($row->exchange_code); ?></td>
                                                <td>
                                                   <?php if($row->status == 0): ?>
                                                    <div class="badge badge-primary badge-shadow">Invoiced</div>
                                                    <?php elseif($row->status == 1): ?>
                                                    <div class="badge badge-info badge-shadow">Partially Paid</div>
                                                    <?php elseif($row->status == 2): ?>
                                                    <div class="badge badge-success badge-shadow">Paid Invoice</div>
                                                    <?php endif; ?>
                                                </td>
                                               
                                                
                                                <td>
                                                  
                                               
                                                        <a class="nav-link" id="profile-tab2"
                                                                    href="<?php echo e(route('pacel.pay',$row->id)); ?>"
                                                                    role="tab"
                                                                    aria-selected="false">Make Payments</a>
                                                            

                                                </td>
                                              
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


     


    </div>
</div>


<?php /**PATH /home/admin/web/del.co.tz/public_html/resources/views/deposit/invoice.blade.php ENDPATH**/ ?>