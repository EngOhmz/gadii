<?php $__env->startSection('content'); ?>
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Bank Reconciliation</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link <?php if(empty($id)): ?> active show <?php endif; ?>" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Bank Reconciliation
                                    List</a>
                            </li>
                       

                        </ul>
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade <?php if(empty($id)): ?> active show <?php endif; ?>" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">

<br>
<?php
$bank=App\Models\AccountCodes::where('id',$account_id)->first();
?>

        <div class="panel-heading">
            <h6 class="panel-title">
                Unreconciled Entries
                <?php if(!empty($start_date)): ?>
                    for the period: <b><?php echo e($start_date); ?> to <?php echo e($end_date); ?> for <?php echo e($bank->account_name); ?></b>
                <?php endif; ?>
            </h6>
        </div>

<br>
        <div class="panel-body hidden-print">
            <?php echo Form::open(array('url' => Request::url(), 'method' => 'post','class'=>'form-horizontal', 'name' => 'form')); ?>

            <div class="row">

                <div class="col-md-4">
                    <label class="">Start Date</label>
                   <input  name="start_date" type="date" class="form-control date-picker" required value="<?php
                if (!empty($start_date)) {
                    echo $start_date;
                } else {
                    echo date('Y-m-d', strtotime('first day of january this year'));
                }
                ?>">

                </div>
                <div class="col-md-4">
                    <label class="">End Date</label>
                     <input  name="end_date" type="date" class="form-control date-picker" required value="<?php
                if (!empty($end_date)) {
                    echo $end_date;
                } else {
                    echo date('Y-m-d');
                }
                ?>">
                </div>
                <div class="col-md-4">
                    <label class="">Bank</label>
                    <?php echo Form::select('account_id',$chart_of_accounts,$account_id, array('class' => 'select2','id'=>'account_id', 'placeholder'=>'Select','required'=>'required')); ?>

                </div>

   <div class="col-md-4">
                      <br><button type="submit" class="btn btn-success">Search</button>
                        <a href="<?php echo e(Request::url()); ?>"class="btn btn-danger">Reset</a>

                </div>                  
                </div>
           
            <?php echo Form::close(); ?>


        </div>

        <!-- /.panel-body -->

   <br>
<?php if(!empty($start_date)): ?>
        <div class="panel panel-white">
            <div class="panel-body ">
                <div class="table-responsive">

                    <?php echo e(Form::open(['route' => 'reconcile.save'])); ?>

                    
                    <?php echo method_field('POST'); ?>
                    <table id="data-table" class="table table-striped table-condensed table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th> Type</th>
                            <th>Date</th>
                            <th>Balance</th>
                            <th>Notes</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>

                          

                        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                        
                        $balance=$key->debit -$key->credit;
                         
                   ?>
                            <tr>
                                <td><?php echo e($loop->iteration); ?></td>
                                <?php if($balance < 0): ?>
                                <td>Withdraw</td>
                                <?php else: ?>
                                <td>Deposit</td>
                                <?php endif; ?>
                                <td><?php echo e($key->date); ?></td>
                                <td><?php echo e(number_format(abs($key->debit -$key->credit),2)); ?></td>
                                <td><?php echo e($key->notes); ?></td>
                                <td><input name="trans_id[]" type="checkbox"  class="checks" value="<?php echo e($key->id); ?>"></td>
                                
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                        <tfoot>
                            <tr class="custom-color-with-td">
                                <td style="text-align: right;" colspan="3"></td>
                                <td></td>
                                    <td></td>
                                     <td><input type="submit" value="Save" name="update" class="btn btn-success"></td>
    
                            </tr>
                        </tfoot>
                    </table>
                    <?php echo Form::close(); ?>

                </div>
            </div>
            <!-- /.panel-body -->
             </div>
    <?php endif; ?>              

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



<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
$(document).ready(function() {
    new TomSelect("#account_id",{
        create: false,
        sortField: {
            field: "text",
            direction: "asc"
        }
    });
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
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/admin/web/gaki.ema.co.tz/public_html/resources/views/accounting/bank_reconciliation.blade.php ENDPATH**/ ?>