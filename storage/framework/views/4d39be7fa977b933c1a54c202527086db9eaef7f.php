<?php $__env->startSection('content'); ?>

<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                      <h4>Driver Details For <?php echo e($driver->driver_name); ?></h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-2">
                                <ul class="nav nav-pills flex-column" id="myTab4" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link "  id="#tab1" 
                                        href="<?php echo e(route('driver.licence', $driver->id)); ?>"  aria-controls="home"
                                            aria-selected="true">Licence</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="#tab2" 
                                            href="<?php echo e(route('driver.performance', $driver->id)); ?>"  aria-controls="profile"
                                            aria-selected="false">Perfomance</a>
                                    </li>
                               <li class="nav-item">
                                        <a class="nav-link  active" id="#tab3" 
                                            href="<?php echo e(route('driver.fuel', $driver->id)); ?>"  aria-controls="profile"
                                            aria-selected="false">Fuel Report</a>
                                    </li>

                               <li class="nav-item">
                                        <a class="nav-link" id="#tab4" 
                                            href="<?php echo e(route('driver.route', $driver->id)); ?>"  aria-controls="profile"
                                            aria-selected="false">Routes</a>
                                    </li>
                                   
                                  
                                     


                                </ul>
                            </div>
                            <div class="col-12 col-sm-12 col-md-10">
                                <div class="tab-content no-padding" id="myTab2Content">
                                    <div class="tab-pane fade <?php if($type =='fuel'): ?> active show  <?php endif; ?>" id="tab1"
                                    role="tabpanel" aria-labelledby="tab1">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4></h4>
                                        </div>
                                        <div class="card-body">
                                           
                                            <div class="tab-content tab-bordered" id="myTab3Content">


                                  <div class="panel-heading">
            <h5 class="panel-title">
               Fuel Report
              <?php if(!empty($start_date)): ?>
                    for the period: <b><?php echo e($start_date); ?> to  <?php echo e($end_date); ?></b>
                <?php endif; ?>
            </h5>
        </div>

<br>
        <div class="panel-body hidden-print">
            <?php echo Form::open(array('url' => Request::url(), 'method' => 'post','class'=>'form-horizontal', 'name' => 'form')); ?>

            <div class="row">

                <div class="col-md-4">
                    <label class="">Start Date</label>
                    <?php echo Form::date('start_date',$start_date, array('class' => 'form-control date-picker', 'placeholder'=>"First Date",'required'=>'required')); ?>

                </div>
                <div class="col-md-4">
                    <label class="">End Date</label>
                   <?php echo Form::date('end_date',$end_date, array('class' => 'form-control date-picker', 'placeholder'=>"Third Date",'required'=>'required')); ?>

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
                                                <div class="tab-pane fade <?php if($type =='fuel'): ?> active show <?php endif; ?>" id="home2" role="tabpanel"
                                                    aria-labelledby="home-tab2">
                                                    <div class="table-responsive">
                                                        <table class="table table-striped" id="table-1">
                                                            <thead>
                                                                <tr>
                                
                                                                    <th>#</th>
                        <th>Date</th>
                 <th>Route Name</th>
                        <th>Assigned Vol</th>
                        <th>Ajdusted Vol</th>
                        <th>Adjusted Vol Approved By</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php if(!@empty($fuel)): ?>
                                                                <?php $__currentLoopData = $fuel; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <tr class="gradeA even" role="row">
                                                                    <th><?php echo e($loop->iteration); ?></th>
                                                                    <td><?php echo e(Carbon\Carbon::parse($row->created_at)->format('d/m/Y')); ?></td>
                                                                    <td>From <?php echo e($row->route->from); ?> to <?php echo e($row->route->to); ?></td>
                                                                   <td><?php echo e(number_format($row->fuel_used,2)); ?> Litres</td>                                                          
                                                                    <td><?php echo e(number_format($row->fuel_adjustment,2)); ?> Litres</td>
                                                                  <?php if(!@empty($row->approved_by)): ?>
                                                                    <td>
                                                                  <?php
                                                              $approve=App\Models\User::find($row->approved_by);
                                                              ?>

                                                <?php echo e($approve->name); ?></td>
                                                              <?php else: ?>
                                                             <td></td>
                                                   <?php endif; ?>
                                
                                                                   
                                                                </tr>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/js/bootstrap-datepicker.min.js"></script>
<script>
    function myFunction() {
       // alert('hellow')
  //var element = document.getElementById("#tab2");
  //element.classList.add("active");
}
</script>
<script type="text/javascript">
 $(document).ready(function(){
  $("#datepicker,#datepicker2").datepicker({
     format: "yyyy",
     viewMode: "years", 
     minViewMode: "years",
     autoclose:true
  });   
})

 </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/admin/web/gaki.ema.co.tz/public_html/resources/views/driver/fuel.blade.php ENDPATH**/ ?>