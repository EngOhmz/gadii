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
                                        <a class="nav-link active "  id="#tab1" 
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
                                        <a class="nav-link" id="#tab4" 
                                            href="<?php echo e(route('driver.route', $driver->id)); ?>"  aria-controls="profile"
                                            aria-selected="false">Routes</a>
                                    </li>
                                   
                                     


                                </ul>
                            </div>
                            <div class="col-12 col-sm-12 col-md-10">
                                <div class="tab-content no-padding" id="myTab2Content">
                                    <div class="tab-pane fade <?php if($type =='licence' || $type == 'edit-licence'): ?> active show  <?php endif; ?>" id="tab1"
                                    role="tabpanel" aria-labelledby="tab1">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4>Licence</h4>
                                        </div>
                                        <div class="card-body">
                                            <ul class="nav nav-tabs" id="myTab2" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link <?php if($type =='licence'): ?> active show <?php endif; ?>" id="home-tab2"
                                                        data-toggle="tab" href="#home2" role="tab" aria-controls="home"
                                                        aria-selected="true">Licence List
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link <?php if($type =='edit-licence'): ?> active show <?php endif; ?>" id="profile-tab2"
                                                        data-toggle="tab" href="#profile2" role="tab" aria-controls="profile"
                                                        aria-selected="false"> New Licence</a>
                                                </li>
                                
                                            </ul>
                                            <div class="tab-content tab-bordered" id="myTab3Content">
                                                <div class="tab-pane fade <?php if($type =='licence'): ?> active show <?php endif; ?>" id="home2" role="tabpanel"
                                                    aria-labelledby="home-tab2">
                                                    <div class="table-responsive">
                                                        <table class="table table-striped" id="table-1">
                                                            <thead>
                                                                <tr role="row">
                                
                                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                                    rowspan="1" colspan="1"
                                                                    aria-label="Browser: activate to sort column ascending"
                                                                    style="width: 208.531px;">#</th>
                                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                                        colspan="1" aria-label="Engine version: activate to sort column ascending"
                                                                        style="width: 141.219px;">Class</th>
                                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                                        colspan="1" aria-label="Engine version: activate to sort column ascending"
                                                                        style="width: 141.219px;"> Issue Year</th>
                                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                                        colspan="1" aria-label="Engine version: activate to sort column ascending"
                                                                        style="width: 141.219px;"> Expire Year</th>
                                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                                        colspan="1" aria-label="Engine version: activate to sort column ascending"
                                                                        style="width: 141.219px;">Attachment</th>
                                                                    
                                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                                        colspan="1" aria-label="CSS grade: activate to sort column ascending"
                                                                        style="width: 98.1094px;">Actions</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php if(!@empty($licence)): ?>
                                                                <?php $__currentLoopData = $licence; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <tr class="gradeA even" role="row">
                                                                    <th><?php echo e($loop->iteration); ?></th>
                                                                    <td><?php echo e($row->class); ?></td>
                                                                    <td><?php echo e($row->year); ?></td>
                                                                    <td><?php echo e($row->expire); ?></td>
                                                                    <?php if(!@empty($row->attachment)): ?>
                                                                    <td><a href="<?php echo e(route('ldownload',['download'=>'pdf','id'=>$row->id])); ?>">Download</a></td>
                                                                    <?php else: ?>
                                                                    <td></td>                
                                                                    <?php endif; ?>
                                
                                
                                                                    <td>
                                                                        
                                                                        <a class="btn btn-xs btn-outline-primary text-uppercase px-2 rounded"
                                                                        href="<?php echo e(route("licence.edit", $row->id)); ?>">
                                                                        <i class="fa fa-edit"></i>
                                                                    </a>
                                                                 
                                
                                                                    <?php echo Form::open(['route' => ['licence.destroy',$row->id],
                                                    'method' => 'delete']); ?>

                                                    <?php echo e(Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-xs btn-outline-danger text-uppercase px-2 rounded demo4', 'title' => 'Delete', 'onclick' => "return confirm('Are you sure?')"])); ?>

                                                    <?php echo e(Form::close()); ?>


                                
                                                                    </td>
                                                                </tr>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                
                                                                <?php endif; ?>
                                
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade <?php if($type =='edit-licence'): ?> active show <?php endif; ?>" id="profile2"
                                                    role="tabpanel" aria-labelledby="profile-tab2">
                                
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <?php if($type =='edit-licence'): ?>
                                                            <h5>Edit Licence</h5>
                                                            <?php else: ?>
                                                            <h5>New Licence</h5>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-sm-12 ">
                                                                    <?php if($type =='edit-licence'): ?>
                                                                    <?php echo e(Form::model($id, array('route' => array('licence.update', $id), 'method' => 'PUT',"enctype"=>"multipart/form-data"))); ?>

                                                                    <?php else: ?>
                                                                    <?php echo e(Form::open(['route' => 'licence.store',"enctype"=>"multipart/form-data"])); ?>

                                                                    <?php echo method_field('POST'); ?>
                                                                    <?php endif; ?>
                                
                                                                    <div class="form-row">
                                                                        <div class="form-group col-md-6">
                                                                            
                                                                            <input type="hidden" name="driver_id" class="form-control" id="type"
                                                                                value="<?php echo e($driver->id); ?>" placeholder="">

                                                                            <label for="inputEmail4">Class</label>
                                                                             <input type="text" name="class"
                                                                         value="<?php echo e(isset($data) ? $data->class : ''); ?>"
                                                            class="form-control" required>
                                                                        </div>
                                                                        <div class="form-group col-md-6">
                                                           
                                                                            <label for="inputEmail4">Licence Attachment</label>
                                                                            <input type="file" name="attachment" class="form-control"
                                                                                id="attachment"
                                                                                value=" <?php echo e(!empty($data) ? $data->attachment : ''); ?>"
                                                                                placeholder="">
                                                                        </div>
                                                                        </div>
                                
                                
                                                                    
                                                                    <div class="form-row">
                                                                        <div class="form-group col-md-6">
                                
                                                                            <label for="inputEmail4">Issue Year</label>
                                                                            <input type="text" name="year" class="form-control" id="datepicker" 
                                                                                value=" <?php echo e(!empty($data) ? $data->year : ''); ?>"  
                                                                                required>
                                                                        </div>
                                                                        
                                                                        <div class="form-group col-md-6 col-lg-6">
                                                                            <label for="date">Expire Year</label>
                                                                            <input type="text" name="expire" class="form-control" id="datepicker2"
                                                                                value="<?php echo e(!empty($data) ? $data->expire : ''); ?>" 
                                                                                required>
                                
                                                                        </div>
                                         
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <div class="col-lg-offset-2 col-lg-12">
                                                                            <?php if($type =='edit-licence'): ?>
                                                                            <button class="btn btn-sm btn-primary float-right m-t-n-xs"
                                                                                data-toggle="modal" data-target="#myModal" type="submit">Update</button>
                                                                            <?php else: ?>
                                                                            <button class="btn btn-sm btn-primary float-right m-t-n-xs"
                                                                                type="submit">Save</button>
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
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/admin/web/del.co.tz/public_html/resources/views/driver/licence.blade.php ENDPATH**/ ?>