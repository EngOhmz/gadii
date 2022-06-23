<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="formModal">Add Insurance</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
           <form id="addLicenceForm" method="post" action="javascript:void(0)">
            <?php echo csrf_field(); ?>
        <div class="modal-body">

            <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">

 <div class="form-row">
              <div class="form-group col-md-6 col-lg-6 col-xl-6">
                <label for="insurancename">Insurance Company</label>
                <input type="text" name='insurancename' class="form-control" id="insurancenameid" placeholder="">
                    <?php $__errorArgs = ['insurancename'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="text-danger"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
              </div>
              <div class="form-group col-md-6 col-lg-6 col-xl-6">
                <label for="insuranceamount">Insurance Amount</label>
                <input type="text" name='insuranceamount' class="form-control" id="insuranceamountid" placeholder="">
                    <?php $__errorArgs = ['insuranceamount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="text-danger"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
              </div>
            </div>
            <div class="form-group col-md-12 col-lg-12 col-xl-12">
              <label for="assetvalue">Asset Value</label>
              <input type="text" name='assetvalue' class="form-control" id="assetvalueid" placeholder="">
                  <?php $__errorArgs = ['assetvalue'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
              <div class="text-danger"><?php echo e($message); ?></div>
              <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="form-group col-md-12 col-lg-12 col-xl-12">
                  <label for="insurancetype">Insurance Type</label>
                  <select name="insurancetype" id="insurancetypeid" class="form-control">
                      <option value=''>Select Insurance Type</option>
                      <option value='private'>Compressive</option>
                      <option value="hired">Third Part</option>
                  </select>
                </div>
            <div class="form-group col-md-12 col-lg-12 col-xl-12">
              <label for="coveringage">Covering Age (Year)</label>
              <input type="number" name='coveringage' class="form-control" id="coveringageid" placeholder="">
                  <?php $__errorArgs = ['coveringage'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
              <div class="text-danger"><?php echo e($message); ?></div>
              <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6 col-lg-6 col-xl-6">
                  <label for="startdate">Start Date</label>
                  <input type="date" name='startdate' class="form-control" id="startdateid" placeholder="Starting date">
                  
                </div>
                <div class="form-group col-md-6 col-lg-6 col-xl-6">
                  <label for="enddate">End Date</label>
                  <input type="date" name='enddate' class="form-control" id="enddateid" placeholder="Ending date">
                </div>
              </div>
                                                    </div>


        </div>
 </div>
              </div>
        <div class="modal-footer bg-whitesmoke br">
            <button type="submit" class="btn btn-primary" id="save" onclick=" saveLicence(this)" data-dismiss="modal">Save</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>


       </form>


    </div>
</div>

<script>    

</script> <?php /**PATH /home/admin/web/gaki.ema.co.tz/public_html/resources/views/cotton/addLicence.blade.php ENDPATH**/ ?>