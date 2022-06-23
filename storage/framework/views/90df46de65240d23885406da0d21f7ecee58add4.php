<?php $__env->startSection('content'); ?>

<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>User Details</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-2">
                                <ul class="nav nav-pills flex-column" id="myTab4" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link <?php if($type == 'basic' || $type == 'edit-basic'): ?> active  <?php endif; ?>" onclick="{ $type = 'preparation'}" id="#tab1" data-toggle="tab"
                                            href="#tab1" role="tab" aria-controls="home"
                                            aria-selected="true">Basic Details</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link <?php if($type == 'bank' || $type == 'edit-bank'): ?> active  <?php endif; ?>" onclick="{ $type = 'bank'}" id="#tab2" data-toggle="tab"
                                            href="#tab2" role="tab" aria-controls="profile"
                                            aria-selected="false">Bank Details</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link <?php if($type == 'fertilizer'): ?> active  <?php endif; ?>" onclick="{ $type = 'fertilizer'}" id="#fertilizer" data-toggle="tab"
                                            href="#fertilizer" role="tab" aria-controls="profile"
                                            aria-selected="false">Document Details</a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link <?php if($type == 'irrigation'): ?> active  <?php endif; ?>" onclick="{ $type = 'irrigation'}" id="#irrigation" data-toggle="tab"
                                            href="#irrigation" role="tab" aria-controls="profile"
                                            aria-selected="false">Sarary Details</a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link <?php if($type == 'sowings'): ?> active  <?php endif; ?>" onclick="myFunction()" id="#tab2" data-toggle="tab"
                                            href="#tab2" role="tab" aria-controls="profile"
                                            aria-selected="false">Time Cards Details</a>
                                    </li>
                                    
                                    
                                    <li class="nav-item">
                                        <a class="nav-link <?php if($type == 'pestiside'): ?> active  <?php endif; ?>" onclick="{ $type = 'pestiside'}" id="#pestiside" data-toggle="tab"
                                            href="#pestiside" role="tab" aria-controls="profile"
                                            aria-selected="false">Leave Details</a>
                                    </li>
                                    
                                    <li class="nav-item">
                                        <a class="nav-link <?php if($type == 'pre_harvest'): ?> active  <?php endif; ?>" onclick="{ $type = 'pre_harvest'}" id="#pre_harvest" data-toggle="tab"
                                            href="#pre_harvest" role="tab" aria-controls="profile"
                                            aria-selected="false">Provident Fund</a>
                                    </li>
                                    
                                    <li class="nav-item">
                                        <a class="nav-link <?php if($type == 'post_harvest'): ?> active  <?php endif; ?>" onclick="{ $type = 'post_harvest'}" id="#post_harvest" data-toggle="tab"
                                            href="#post_harvest" role="tab" aria-controls="profile"
                                            aria-selected="false">Overtime Details</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link <?php if($type == 'post_harvest'): ?> active  <?php endif; ?>" onclick="{ $type = 'post_harvest'}" id="#post_harvest" data-toggle="tab"
                                            href="#post_harvest" role="tab" aria-controls="profile"
                                            aria-selected="false">Task Details</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link <?php if($type == 'post_harvest'): ?> active  <?php endif; ?>" onclick="{ $type = 'post_harvest'}" id="#post_harvest" data-toggle="tab"
                                            href="#post_harvest" role="tab" aria-controls="profile"
                                            aria-selected="false">Projects Details</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link <?php if($type == 'post_harvest'): ?> active  <?php endif; ?>" onclick="{ $type = 'post_harvest'}" id="#post_harvest" data-toggle="tab"
                                            href="#post_harvest" role="tab" aria-controls="profile"
                                            aria-selected="false">Client Issues</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link <?php if($type == 'post_harvest'): ?> active  <?php endif; ?>" onclick="{ $type = 'post_harvest'}" id="#post_harvest" data-toggle="tab"
                                            href="#post_harvest" role="tab" aria-controls="profile"
                                            aria-selected="false">Activities</a>
                                    </li>


                                </ul>
                            </div>
                            <div class="col-12 col-sm-12 col-md-10">
                                <div class="tab-content no-padding" id="myTab2Content">
                                 
                                 <?php echo $__env->make('user_details.tabs.tab1', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                 <?php echo $__env->make('user_details.tabs.tab2', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                 <?php echo $__env->make('user_details.tabs.tab3', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                 <?php echo $__env->make('user_details.tabs.tab4', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                 <?php echo $__env->make('user_details.tabs.tab5', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                 <?php echo $__env->make('user_details.tabs.tab6', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                 <?php echo $__env->make('user_details.tabs.tab7', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                 <?php echo $__env->make('user_details.tabs.tab8', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                 <?php echo $__env->make('user_details.tabs.tab9', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                 <?php echo $__env->make('user_details.tabs.tab10', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                 <?php echo $__env->make('user_details.tabs.tab11', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                 <?php echo $__env->make('user_details.tabs.tab12', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                  
                                








                               
                               
                               
 

                                </div>
         
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
   
 
</section>
<div class="modal fade bd-example-modal-lg" id="appFormModal" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    function myFunction() {
       // alert('hellow')
  //var element = document.getElementById("#tab2");
  //element.classList.add("active");
}
</script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/admin/web/app.ema.co.tz/public_html/resources/views/user_details/index.blade.php ENDPATH**/ ?>