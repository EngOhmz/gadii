<?php $__env->startSection('content'); ?>
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Reverse Top Up Center</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link <?php if(empty($id)): ?> active show <?php endif; ?>" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">ReverseTop Up
                                    List</a>
                            </li>
                            

                        </ul>
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade <?php if(empty($id)): ?> active show <?php endif; ?>" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="table-1">
                                       <thead>
                                            <tr>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Browser: activate to sort column ascending"
                                                    style="width: 208.531px;">#</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 186.484px;">Transaction id</th>
                                               
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Operator</th>
                                               <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Collection Center</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Amount</th>
                                                      <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Date</th>
                                   
                                               
                                            </tr>
                                        </thead>
                                         <tbody>
                                            <?php if(!@empty($transfer)): ?>
                                            <?php $__currentLoopData = $transfer; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr class="gradeA even" role="row">
                                                <th><?php echo e($loop->iteration); ?></th>
                                                <td><?php echo e($row->reference); ?></td>
                                           <td><?php echo e($row->chart_from->name); ?></td> 
                                                <td><?php echo e($row->chart_to->name); ?></td>                                     
                                                  <td><?php echo e(number_format($row->due_amount,2)); ?> <?php echo e($row->exchange_code); ?></td>
                                                   <td><?php echo e($row->date); ?></td>
                                                 
                                            </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                            <?php endif; ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade <?php if(!empty($id)): ?> active show <?php endif; ?>" id="profile2" role="tabpanel"
                                aria-labelledby="profile-tab2">

                                <div class="card">
                                    <div class="card-header">
                                        <?php if(empty($id)): ?>
                                        <h5>Create Top Up</h5>
                                        <?php else: ?>
                                        <h5>Edit Top Up</h5>
                                        <?php endif; ?>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">
                                                <?php if(isset($id)): ?>
                                                <?php echo e(Form::model($id, array('route' => array('top_up_center.update', $id), 'method' => 'PUT'))); ?>

                                                <?php else: ?>
                                                <?php echo e(Form::open(['route' => 'top_up_center.store'])); ?>

                                                <?php echo method_field('POST'); ?>
                                                <?php endif; ?>

                                                       <div class="form-group row"><label
                                                        class="col-lg-2 col-form-label">Operator</label>
                                                    <div class="col-lg-8">
                                                       <select class="form-control operator" name="from_account_id" id="user_id" required>
                                                    <option value="">Select Operator</option> 
                                                          <?php $__currentLoopData = $operator; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bank): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>                                                             
                                                            <option value="<?php echo e($bank->id); ?>" <?php if(isset($data)): ?><?php if($data->to_account_id == $bank->id): ?> selected <?php endif; ?> <?php endif; ?> ><?php echo e($bank->name); ?></option>
                                                               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                              </select>
                                                    </div>
                                                </div>
                                       
                                                   <div class="form-group row">
                     <?php if(!empty($data)): ?>
                      <label
                                                        class="col-lg-2 col-form-label">Collection Center</label>
                                                    <div class="col-lg-8">
                                                       <select class="form-control" name="to_account_id" id="account_id"  required>
                                                    <option value="">Select Collection Center</option> 
                                                        <?php $__currentLoopData = $center; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>                                                             
                                                            <option value="<?php echo e($c->id); ?>" <?php if(isset($data)): ?><?php if($data->to_account_id == $c->id): ?> selected <?php endif; ?> <?php endif; ?> ><?php echo e($c->name); ?></option>
                                                               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                              </select>
                                                    </div>
                 <?php else: ?>
                                 <label
                                                        class="col-lg-2 col-form-label">Collection Center</label>
                                                    <div class="col-lg-8">
                                                       <select class="form-control " name="to_account_id" id="account_id"  required>
                                                    <option value="">Select Collection Center</option> 
                                                      
                                                              </select>
                                                    </div>
  <?php endif; ?>
         </div>                                      

                                               <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Amount</label>
                                                    <div class="col-lg-8">
                                                        <input type="number" name="amount" required
                                                            placeholder=""
                                                            value="<?php echo e(isset($data) ? $data->amount : ''); ?>"
                                                            class="form-control amount">
                                                    </div>
                                           <div class=""> <p class="form-control-static" id="errors" style="text-align:center;color:red;"></p>   </div> 
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

                                                <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Currency</label>
                                                    <div class="col-lg-8">
                                                        <select class="form-control" name="exchange_code"
                                                            id="currency_code" required>
                                                            <option value="<?php echo e(old('currency_code')); ?>" disabled selected>
                                                                Choose option</option>                                                
                                                            <?php if(isset($currency)): ?>
                                                            <?php $__currentLoopData = $currency; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option <?php if(isset($data)): ?>
                                                            <?php echo e($data->exchange_code == $row->code  ? 'selected' : ''); ?>

                                                            <?php endif; ?> value="<?php echo e($row->code); ?>"><?php echo e($row->name); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            <?php endif; ?>
                                                        </select>
                                                        <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                        <p class="text-danger">. <?php echo e($message); ?></p>
                                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                    </div> </div>

                                                    <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Exchange Rate</label>
                                                    <div class="col-lg-8">
                                                        <input type="number" name="exchange_rate"
                                                            placeholder="1 if TZSH"
                                                            value="<?php echo e(isset($data) ? $data->exchange_rate : ''); ?>"
                                                            class="form-control" required>
                                                    </div>
                                                </div>
                                              
                                                  <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Notes</label>
                                                    <div class="col-lg-8">
                                                        <textarea name="notes"
                                                            placeholder=""
                                                            class="form-control" rows="2"></textarea>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-lg-offset-2 col-lg-12">
                                                        <?php if(!@empty($id)): ?>
                                                        <button class="btn btn-sm btn-primary float-right m-t-n-xs"
                                                            data-toggle="modal" data-target="#myModal"
                                                            type="submit" id="save">Update</button>
                                                        <?php else: ?>
                                                        <button class="btn btn-sm btn-primary float-right m-t-n-xs"
                                                            type="submit" id="save">Save</button>
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
                </div>
            </div>
        </div>

    </div>
</section>

 <!-- discount Modal -->
  <div class="modal inmodal show " id="appFormModal" tabindex="-1" role="dialog" aria-hidden="true">
                          <div class="modal-dialog">
    </div>
</div></div>
  </div>


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


<script>
$(document).ready(function() {


    $(document).on('change', '.amount', function() {
        var id = $(this).val();
        var user=$('#user_id').val();
       var account=$('#account_id').val();
        $.ajax({
            url: '<?php echo e(url("findCenter")); ?>',
            type: "GET",
            data: {
                id: id,
                  user: user,
                 account: account,
            },
            dataType: "json",
            success: function(data) {
              console.log(data);
            $("#errors").empty();
            $("#save").attr("disabled", false);
             if (data != '') {
           $("#errors").append(data);
           $("#save").attr("disabled", true);
} else {
  
}
            
       
            }

        });

    });






});
</script>


<script>
$(document).ready(function() {

    $(document).on('change', '.operator', function() {
        var id = $(this).val();
        $.ajax({
            url: '<?php echo e(url("findCenterName")); ?>',
            type: "GET",
            data: {
                id: id
            },
            dataType: "json",
            success: function(response) {
                console.log(response);
                $("#account_id").empty();
                $("#account_id").append('<option value="">Select Collection Center</option>');
                $.each(response,function(key, value)
                {
                 
                    $("#account_id").append('<option value=' + value.id+ '>' + value.name + '</option>');
                   
                });                      
               
            }

        });

    });





});
</script>

<script type="text/javascript">
    function model(id,type) {

        $.ajax({
            type: 'GET',
            url: '<?php echo e(url("reverseCenterModal")); ?>',
            data: {
                'id': id,
                'type':type,
            },
            cache: false,
            async: true,
            success: function(data) {
                //alert(data);
                $('.modal-dialog').html(data);
            },
            error: function(error) {
                $('#appFormModal').modal('toggle');

            }
        });

    }

</script>

<script src="<?php echo e(url('assets/js/plugins/sweetalert/sweetalert.min.js')); ?>"></script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/admin/web/app.ema.co.tz/public_html/resources/views/cotton/reverse_top_up_center.blade.php ENDPATH**/ ?>