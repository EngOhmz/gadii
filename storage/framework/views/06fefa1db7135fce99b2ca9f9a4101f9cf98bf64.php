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
                                        <a class="nav-link " id="#tab3" 
                                            href="<?php echo e(route('driver.fuel', $driver->id)); ?>"  aria-controls="profile"
                                            aria-selected="false">Fuel Report</a>
                                    </li>

                               <li class="nav-item">
                                        <a class="nav-link active" id="#tab4" 
                                            href="<?php echo e(route('driver.route', $driver->id)); ?>"  aria-controls="profile"
                                            aria-selected="false">Routes</a>
                                    </li>
                                  
                                     


                                </ul>
                            </div>
                            <div class="col-12 col-sm-12 col-md-10">
                                <div class="tab-content no-padding" id="myTab2Content">
                                    <div class="tab-pane fade <?php if($type =='route'): ?> active show  <?php endif; ?>" id="tab1"
                                    role="tabpanel" aria-labelledby="tab1">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4></h4>
                                        </div>
                                        <div class="card-body">
                                           
                                            <div class="tab-content tab-bordered" id="myTab3Content">


                                  <div class="panel-heading">
            <h5 class="panel-title">
               Route Report
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
                                                <div class="tab-pane fade <?php if($type =='route'): ?> active show <?php endif; ?>" id="home2" role="tabpanel"
                                                    aria-labelledby="home-tab2">
                                                    <div class="table-responsive">
                                                        <table class="table table-striped">
                                                            <thead>
                                                                <tr>
                                
                                                                                                            <th>#</th>
                        <th>Date</th>
<th>Truck</th>
           <th>REF NO</th>
 <th>Shipment Name</th>
                 <th>Route Name</th>
                        <th>Status</th>
                  
                       
    
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php if(!@empty($route)): ?>
                                                                <?php $__currentLoopData = $route; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <tr class="gradeA even" role="row">
                                                                    <td><?php echo e($loop->iteration); ?></td>                                                                    
                                                                    <td><?php echo e(Carbon\Carbon::parse($row->collection_date)->format('d/m/Y')); ?></td>
                                                                  <td><?php echo e($row->truck->reg_no); ?></td>  
                                                                    <td><?php echo e($row->pacel_number); ?></td>  
                                                                    <td><?php echo e($row->pacel_name); ?></td>  
                                                                    <td>From <?php echo e($row->route->from); ?> to <?php echo e($row->route->to); ?></td>
                                                                    <td>
                                                    <?php if($row->status == 3): ?>
                                                    <div class="badge badge-success badge-shadow">Collected</div>
                                                       <?php elseif($row->status == 4): ?>
                                                    <div class="badge badge-success badge-shadow">Loaded</div>
                                                       <?php elseif($row->status == 5): ?>
                                                    <div class="badge badge-info badge-shadow">Offloaded</div>
                                                      <?php elseif($row->status == 6): ?>
                                                    <div class="badge badge-success badge-shadow">Delivered</div>
                                                    <?php endif; ?>
                                                </td>
                                              
                                               
                                                                
                                                                 
                                
                                                                   
                                                                </tr>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                         <?php echo e($route->links()); ?>

                                                           
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
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/admin/web/app.ema.co.tz/public_html/resources/views/driver/route.blade.php ENDPATH**/ ?>