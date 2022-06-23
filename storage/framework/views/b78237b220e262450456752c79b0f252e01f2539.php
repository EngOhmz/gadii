<?php $__env->startSection('content'); ?>
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-4">
                <div class="card row">
                    <div class="card-header">
                        <h4>Cotton Sales Amount</h4>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>

                                <tr>

                                    <th scope="col">Ref No</th>
                                    <th scope="col">Due Amount</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($invoice)): ?>
                      
                                <tr>


                                    <td><a href="<?php echo e(route('cotton_sales.show',$invoice->id)); ?>"><?php echo e($invoice->reference); ?>

                                            </a></td>
                                    <td><?php echo e($invoice->due_amount); ?> <?php echo e($invoice->exchange_code); ?> </td>
                                    <td> 
                                        <?php if($invoice->status == 1): ?>
                                        <div class="badge badge-warning badge-shadow">Not Paid</div>
                                        <?php elseif($invoice->status == 2): ?>
                                        <div class="badge badge-info badge-shadow">Partially Paid</div>
                                        <?php elseif($invoice->status == 3): ?>
                                        <span class="badge badge-success badge-shadow">Fully Paid</span>
                                       
                                        <?php endif; ?>
                                       
                                    </td>


                                </tr>
                                
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                
            </div>
            <div class="col-12 col-sm-6 col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <?php if(empty($id)): ?>
                        <h5>Make Payments</h5>
                        <?php else: ?>
                        <h5>Edit Payments</h5>
                        <?php endif; ?>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 ">
                                <?php if(isset($id)): ?>
                                <?php echo e(Form::model($id, array('route' => array('cotton_sales_payment.update', $id), 'method' => 'PUT'))); ?>

                                <?php else: ?>
                                <?php echo e(Form::open(['route' => 'cotton_sales_payment.store'])); ?>

                                <?php echo method_field('POST'); ?>
                                <?php endif; ?>



                                <div class="form-group row">

                                    <label class="col-lg-2 col-form-label">Amount
                                    </label>
                                    <div class="col-lg-10">
                                        <input type="number" name="amount"
                                            value="<?php echo e($invoice->due_amount); ?>" class="form-control">

                                            <input type="hidden" name="invoice_id"
                                            value="<?php echo e($invoice->id); ?>" class="form-control">
                                    </div>
                                </div>


                                <div class="form-group row"><label class="col-lg-2 col-form-label">Payment Date</label>

                                    <div class="col-lg-10">
                                        <input type="date" name="date" value="<?php echo e(isset($data) ? $data->date : date('d/m/y')); ?>"
                                            class="form-control" required>
                                    </div>
                                </div>

                                <div class="form-group row"><label class="col-lg-2 col-form-label">Payment
                                        Method</label>

                                    <div class="col-lg-10">
                                        <select class="form-control m-b" name="payment_method">
                                            <option value="">Select
                                            </option>
                                            <?php if(!empty($payment_method)): ?>
                                            <?php $__currentLoopData = $payment_method; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($row->id); ?>" <?php if(isset($data)): ?><?php if($data->
                                                manager_id == $row->id): ?> selected <?php endif; ?> <?php endif; ?> >From
                                                <?php echo e($row->name); ?>

                                            </option>

                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                        </select>

                                    </div>
                                </div>

                                <div class="form-group row"><label class="col-lg-2 col-form-label">Notes</label>

                                    <div class="col-lg-10">
                                        <textarea name="notes" 
                                            class="form-control"></textarea>
                                    </div>
                                </div>



                              
                                <div class="form-group row"><label  class="col-lg-2 col-form-label">Bank/Cash Account</label>

                                    <div class="col-lg-10">
                                       <select class="form-control" name="account_id" required>
                                    <option value="">Select Payment Account</option> 
                                          <?php $__currentLoopData = $bank_accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bank): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>                                                             
                                            <option value="<?php echo e($bank->id); ?>" <?php if(isset($data)): ?><?php if($data->account_id == $bank->id): ?> selected <?php endif; ?> <?php endif; ?> ><?php echo e($bank->account_name); ?></option>
                                               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                              </select>
                                    </div>
                                </div>




                                <div class="form-group row">
                                    <div class="col-lg-offset-2 col-lg-12">
                                        <?php if(!@empty($id)): ?>
                                        <button class="btn btn-sm btn-primary float-right m-t-n-xs" data-toggle="modal"
                                            data-target="#myModal" type="submit">Update</button>
                                        <?php else: ?>
                                        <button class="btn btn-sm btn-primary float-right m-t-n-xs" type="submit">Add
                                            Payments</button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php echo Form::close(); ?>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>



<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
$(document).ready(function() {
    $('.dataTables-example').DataTable({
        pageLength: 25,
        responsive: true,
        dom: '<"html5buttons"B>lTfgitp',
        buttons: [{
                extend: 'copy'
            },
            {
                extend: 'csv'
            },
            {
                extend: 'excel',
                title: 'ExampleFile'
            },
            {
                extend: 'pdf',
                title: 'ExampleFile'
            },

            {
                extend: 'print',
                customize: function(win) {
                    $(win.document.body).addClass('white-bg');
                    $(win.document.body).css('font-size', '10px');

                    $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', 'inherit');
                }
            }
        ]

    });

});
</script>
<script src="<?php echo e(url('assets/js/plugins/sweetalert/sweetalert.min.js')); ?>"></script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/admin/web/gaki.ema.co.tz/public_html/resources/views/cotton/cotton_payment.blade.php ENDPATH**/ ?>