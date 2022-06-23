<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="formModal">Reverse Top up to Operator</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
           <?php echo e(Form::open(['url' => url('newreverseCenter')])); ?>

       <?php echo method_field('POST'); ?>
            <?php echo csrf_field(); ?>
        <div class="modal-body">

            <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">

                                      <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Reference </label>
                                                    <div class="col-lg-8">
                                                        <input type="text" name="reference" 
                                                            placeholder=""
                                                            value="<?php echo e(isset($data) ? $data->reference : ''); ?>"
                                                            class="form-control ">
                                                    </div>
                                          
                                                </div>

 <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Date</label>
                                                    <div class="col-lg-8">
                                                        <input type="date" name="date" required
                                                            placeholder=""
                                                            value="<?php echo e(isset($data) ? $data->date: ''); ?>"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                               
                                                <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Amount</label>
                                                    <div class="col-lg-8">
                                                        <input type="number" name="amount" required
                                                            placeholder=""
                                                            value="<?php echo e(isset($data) ? $data->amount : ''); ?>"
                                                            class="form-control reverse_amount">
                                                    </div>
                                      <div class=""> <p class="form-control-static" id="errors" style="text-align:center;color:red;"></p>   </div> 
                                                </div>
 
                                                <div class="form-group row"><label class="col-lg-2 col-form-label">Payment
                                                    Method</label>
            
                                                <div class="col-lg-8">
                                                    <select class="form-control m-b" name="payment_method" required>
                                                        <option value="">Select
                                                        </option>
                                                        <?php if(!empty($payment_method)): ?>
                                                        <?php $__currentLoopData = $payment_method; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($row->id); ?>" <?php if(isset($data)): ?><?php if($data->
                                                            payment_method == $row->id): ?> selected <?php endif; ?> <?php endif; ?> >From
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
                   <input type="hidden" name="id" required
                                                            placeholder=""
                                                            value="<?php echo e($id); ?>" id="operator"
                                                            class="form-control">
               
              </div>
</div>
                                                    </div>


        </div>
        <div class="modal-footer bg-whitesmoke br">
            <button type="submit" class="btn btn-primary" id="reverse_save">Save</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>


       </form>


    </div>
</div>


<?php /**PATH /home/admin/web/gaki.ema.co.tz/public_html/resources/views/cotton/addReversedCenter.blade.php ENDPATH**/ ?>