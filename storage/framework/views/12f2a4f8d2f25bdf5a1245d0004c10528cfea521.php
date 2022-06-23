<?php $__env->startSection('content'); ?>
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Chart of Accounts</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link <?php if(empty($id)): ?> active show <?php endif; ?>" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Chart of Accounts
                                    List</a>
                            </li>
                       

                        </ul>
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade <?php if(empty($id)): ?> active show <?php endif; ?>" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">
                               <div class="table-responsive">
                    <table id="data-table" class="table table-striped table-condensed table-hover">
                                       <thead>
                                            <tr>
                                                <th>Account Type</th>
                                                <th>Account Class</th>
                                                 <th>Account Group</th>
                                                <th>Code Name</th>
                                                    <th>Account Code</th>
                                              
                                            </tr>
                                        </thead>
                                         <tbody>
                                            <?php if(!@empty($data)): ?>
                                            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                 <?php  $e=0;   ?>
                                            <tr class="gradeA even" role="row">
                                                 <td colspan="5" style="text-align:"><b><?php echo e($loop->iteration); ?> . <?php echo e($account_type->type); ?> </b></td>
                                                      
                    </tr>
     <?php $__currentLoopData = $account_type->classAccount; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account_class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php    $e++ ;  ?>
                          <tr>
                          <td></td>
                        <td  style="text-align: "><b><?php echo e($e); ?> . <?php echo e($account_class->class_name); ?></b></td>
                        <td></td>
                         <td></td>
                        <td></td>
                    </tr>

   <?php     
$d=0;
?>
               
  <?php $__currentLoopData = $account_class->groupAccount; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                             <?php $d++ ; 
                      //  $values = explode(",",  $account_group->holidays);


?>
                               
                        
                         <tr>
                          <td></td>
                           <td></td>
                           
                          <td style="text-align:r"><b><?php echo e($d); ?> . <?php echo e($group->name); ?></b></td>
                           <td></td>
                           <td></td>
                   
                      
                 
              
                   </tr>
       
<?php $__currentLoopData = $group->accountCodes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account_code): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<tr>
 <td></td>
 <td></td>
  <td></td>
  <td><?php echo e($account_code->account_name); ?></td>
 <td style="text-align:center"><?php echo e($account_code->account_codes); ?></td>
</tr>
   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>              
  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
 <?php endif; ?>
                                        </tbody>
                                    </table>
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
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/admin/web/del.co.tz/public_html/resources/views/chart_of_account/data.blade.php ENDPATH**/ ?>