<?php $__env->startSection('content'); ?>
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Debtors Report</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link <?php if(empty($id)): ?> active show <?php endif; ?>" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Debtors Report
                                    List</a>
                            </li>
                       

                        </ul>
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade <?php if(empty($id)): ?> active show <?php endif; ?>" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">

<br>
<?php
$center=App\Models\AccountCodes::where('id',$account_id)->first();
?>

        <div class="panel-heading">
            <h6 class="panel-title">
              DebtorsReport
                <?php if(!empty($start_date)): ?>
                    for the period: <b><?php echo e($start_date); ?> to <?php echo e($end_date); ?> for <?php echo e($center->account_name); ?></b>
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
                    <label class="">Debtors List</label>
                    <?php echo Form::select('account_id',$chart_of_accounts,$account_id, array('class' => 'select2','id'=>'account_id','placeholder'=>'Select','style'=>'width:100%','required'=>'required')); ?>

                  
                </div>

   <div class="col-md-4">
                      <br><button type="submit" class="btn btn-success">Search</button>
                        <a href="<?php echo e(Request::url()); ?>"class="btn btn-danger">Reset</a>

                </div>                  
                </div>
           
            <?php echo Form::close(); ?>


        </div>

        <!-- /.panel-body -->

   <br> <br>
<?php if(!empty($start_date)): ?>
        <div class="panel panel-white">
            <div class="panel-body ">
                <div class="table-responsive">

                   <table class="table table-striped table-condensed table-hover" id="tableExport" style="width:100%;">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Type</th>
                            <th> Reference</th>
                            <th>Invoice Date</th>
                            <th>Due Date</th>
                            <th>Current</th>
                         <th> 1-30 Days</th>
                            <th> 31-60 Days</th>
                            <th>61-90 Days</th>
                            <th>91-120 Days</th>
                            <th>Over 120 Days</th>
                            <th>Total</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>

                          <?php
            $total1 = $total2 = $total3 = $total4 = $total5 = $total6= $total7= 0; 
?>

                        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <?php
                        $dueDate = strtotime($key->due_date);
                          $todayDate= strtotime(date('d-m-Y'));
                          $datediff = $dueDate - $todayDate;
                           round($datediff / (60 * 60 * 24));
                          $dateDifferences = round($datediff / (60 * 60 * 24));
                         $invoice_due =$key->due_amount;
                        
                        ?>
                            <tr>
                                <td><?php echo e($loop->iteration); ?></td>
                                <td><?php echo e($key->type); ?></td>
                      <td><?php echo e($key->reference); ?></td>
                      <td><?php echo e(Carbon\Carbon::parse($key->purchase_date)->format('d/m/Y')); ?> </td>
                       <td><?php echo e(Carbon\Carbon::parse($key->due_date)->format('d/m/Y')); ?> </td>
                                    <td>
                                   <?php      
                           if($dateDifferences > 0){                          
                            echo number_format($invoice_due, 2) . ' ' .$key->exchange_code; 
                            $total1 = $total1 + $invoice_due;
                         } ?>
                                       </td>
                              <td>
                                   <?php      
                          if($dateDifferences < 0 && $dateDifferences >-31){  
                           $total2 = $total2 + $invoice_due;
                            echo number_format($invoice_due, 2). ' ' .$key->exchange_code;  
                         } ?>
                                       </td>                               
                            <td>
                                   <?php      
                         if($dateDifferences < -30 && $dateDifferences >-61){  
                              $total3 = $total3 + $invoice_due;                         
                            echo number_format($invoice_due, 2). ' ' .$key->exchange_code; 
                           
                         } ?>
                                       </td>
                               <td>
                                   <?php      
                          if($dateDifferences < -60 && $dateDifferences > -91){  
                            $total4 = $total4+ $invoice_due;                        
                            echo number_format($invoice_due, 2). ' ' .$key->exchange_code; 
                         } ?>
                                       </td>
                               <td>
                                   <?php      
                        if($dateDifferences < -90 && $dateDifferences > -120){ 
                       $total5 = $total5 + $invoice_due;                         
                            echo number_format($invoice_due, 2). ' ' .$key->exchange_code;  
                         } ?>
                                       </td>                             
                             <td>
                                   <?php      
                          if($dateDifferences < -120){     
                         $total6 = $total6 + $invoice_due;                    
                            echo number_format($invoice_due, 2). ' ' .$key->exchange_code; 
                         } ?>
                                       </td>
          
                            <td><?php echo e(number_format($invoice_due,2)); ?> <?php echo e($key->exchange_code); ?></td>                      
                           
                                           <td> 
                                                  <?php if($key->status == 1): ?>
                                                    <div class="badge badge-warning badge-shadow">Not Paid</div>
                                                    <?php elseif($key->status == 2): ?>
                                                    <div class="badge badge-info badge-shadow">Partially Paid</div>
                                                    <?php elseif($key->status == 3): ?>
                                                    <div class="badge badge-success badge-shadow">Fully Paid</div>
                                                    <?php endif; ?>
                                             </td>                                
                            </tr>
                        
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                        
                    </table>
                  
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
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/admin/web/gaki.ema.co.tz/public_html/resources/views/cotton/debtors_report.blade.php ENDPATH**/ ?>