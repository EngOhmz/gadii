<?php $__env->startSection('content'); ?>
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Driver</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link <?php if(empty($id)): ?> active show <?php endif; ?>" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Driver
                                    List</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php if(!empty($id)): ?> active show <?php endif; ?>" id="profile-tab2"
                                    data-toggle="tab" href="#profile2" role="tab" aria-controls="profile"
                                    aria-selected="false">New Driver</a>
                            </li>

                        </ul>
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade <?php if(empty($id)): ?> active show <?php endif; ?>" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="table-1">
                                        <thead>
                                            <tr role="row">

                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Browser: activate to sort column ascending"
                                                    style="width: 20.531px;">#</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 186.484px;">Full Name</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Address</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Mobile No</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Licence No</th>
                                              <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Employment</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Status</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Availability</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if(!@empty($driver)): ?>
                                            <?php $__currentLoopData = $driver; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr class="gradeA even" role="row">
                                                <th><?php echo e($loop->iteration); ?></th>
                                                <td><?php echo e($row->driver_name); ?></td>
                                                <td><?php echo e($row->address); ?></td>
                                                <td><?php echo e($row->mobile_no); ?></td>
                                                <td><?php echo e($row->licence); ?></td>
                                                <td>
                                             <?php if($row->type == 'owned'): ?>
                                               Hired by Company
                                              <?php else: ?>
                                               Hired by Third Party Company
                                         <?php endif; ?>
                                                </td>
                                                <td><?php echo e($row->driver_status); ?></td>
                                              <td>
                                             <?php if($row->available == '0'): ?>
                                               Unavailale
                                              <?php else: ?>
                                              Available
                                         <?php endif; ?>
                                                </td>
                                                <td>
                                                    <a class="btn btn-xs btn-outline-info text-uppercase px-2 rounded"
                                                    href="<?php echo e(route('driver.licence', $row->id)); ?>">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                    <a class="btn btn-xs btn-outline-primary text-uppercase px-2 rounded"
                                                        href="<?php echo e(route("driver.edit", $row->id)); ?>">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <?php echo Form::open(['route' => ['driver.destroy',$row->id],
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
                            <div class="tab-pane fade <?php if(!empty($id)): ?> active show <?php endif; ?>" id="profile2" role="tabpanel"
                                aria-labelledby="profile-tab2">

                                <div class="card">
                                    <div class="card-header">
                                        <?php if(!empty($id)): ?>
                                        <h5>Edit Driver</h5>
                                        <?php else: ?>
                                        <h5>Add New Driver</h5>
                                        <?php endif; ?>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">
                                                <?php if(isset($id)): ?>
                                                <?php echo e(Form::model($id, array('route' => array('driver.update', $id), 'method' => 'PUT',"enctype"=>"multipart/form-data"))); ?>

                                                <?php else: ?>
                                                <?php echo Form::open(array('route' => 'driver.store',"enctype"=>"multipart/form-data")); ?>

                                                <?php echo method_field('POST'); ?>
                                                <?php endif; ?>

                                                <div class="form-group row"><label class="col-lg-2 col-form-label">Full Name</label>
                                                   <div class="col-lg-10">
                                                           <input type="text" name="driver_name"
                                                            value="<?php echo e(isset($data) ? $data->driver_name : ''); ?>"
                                                            class="form-control" required>
                                                    </div>
                                                </div>
                                               
                                                <div class="form-group row"><label
                                                        class="col-lg-2 col-form-label">Address</label>

                                                    <div class="col-lg-10">
                                                        <input type="text" name="address"
                                                            value="<?php echo e(isset($data) ? $data->address : ''); ?>"
                                                            class="form-control" required>
                                                    </div>
                                                </div>

                                          <div class="form-group row"><label
                                                        class="col-lg-2 col-form-label">Phone Number</label>

                                                    <div class="col-lg-10">
                                                        <input type="text" name="mobile_no"
                                                            value="<?php echo e(isset($data) ? $data->mobile_no : ''); ?>"
                                                            class="form-control" required>
                                                    </div>
                                                </div>
                                           <div class="form-group row"><label
                                                        class="col-lg-2 col-form-label">Licence No</label>

                                                    <div class="col-lg-10">
                                                        <input type="text" name="licence"
                                                            value="<?php echo e(isset($data) ? $data->licence : ''); ?>"
                                                            class="form-control" required>
                                                    </div>
                                                </div>
                                                   <div class="form-group row"><label
                                                        class="col-lg-2 col-form-label">Referee</label>

                                                    <div class="col-lg-10">
                                                        <input type="text" name="referee"
                                                            value="<?php echo e(isset($data) ? $data->referee : ''); ?>"
                                                            class="form-control" required>
                                                    </div>
                                                </div>
                                                <div class="form-group row"><label class="col-lg-2 col-form-label">Experience</label>
                                                    <div class="col-lg-10">
                                                            <input type="text" name="experience"
                                                             value="<?php echo e(isset($data) ? $data->experience : ''); ?>"
                                                             class="form-control" required>
                                                     </div>
                                                 </div>
                                                
                                         <div class="form-group row"><label
                                                class="col-lg-2 col-form-label"> Employment</label>

                                            <div class="col-lg-10">
                                               <select class="form-control select2" style="width: 100%"  name="type" required>
                                                   <option value="">Select</option>
                                               <option <?php if(isset($data)): ?>
                                                   <?php echo e($data->type == 'owned'  ? 'selected' : ''); ?>

                                                   <?php endif; ?> value="owned">Hired by Company</option>
                                                   <option <?php if(isset($data)): ?>
                                                   <?php echo e($data->type == 'non_owned'  ? 'selected' : ''); ?>

                                                   <?php endif; ?> value="non_owned">Hired by Third Party Company</option>
                                                 </select>
                                                
                                            </div>
                                        </div>
                                                 <div class="form-group row"><label
                                                         class="col-lg-2 col-form-label">Status</label>
 
                                                     <div class="col-lg-10">
                                                        <select class="form-control select2" style="width: 100%" name="driver_status" required>
                                                            <option value="">Select Status</option>
                                                        <option <?php if(isset($data)): ?>
                                                            <?php echo e($data->driver_status == 'Permanent Driver'  ? 'selected' : ''); ?>

                                                            <?php endif; ?> value="Permanent Driver">Permanent Driver</option>
                                                            <option <?php if(isset($data)): ?>
                                                            <?php echo e($data->driver_status == 'Temporary Driver'  ? 'selected' : ''); ?>

                                                            <?php endif; ?> value="Temporary Driver">Temporary Driver</option>
                                                    </select>
                                                         
                                                     </div>
                                                 </div>
                                                    <div class="form-group row"><label
                                                         class="col-lg-2 col-form-label">Profile Picture</label>
 
                                                     <div class="col-lg-10">
                                                        <?php if(!@empty($data->profile)): ?>
                                                        
                                         <input  type="file" name="profile" required value="<?php echo e($data->profile); ?>" class="form-control" onchange="loadBigFile(event)">
                                         <br><img src="<?php echo e(url('storage/assets/img/driver')); ?>/<?php echo e($data->profile); ?>" alt="<?php echo e($data->driver_name); ?>" width="100">
                                         <?php else: ?>
                                       <input type="file" name="profile" required  class="form-control" onchange="loadBigFile(event)">
                                                        <?php endif; ?>
                                                                                           
                                                                                                 <br>
                                                          <img id="big_output" width="100">


                                                         
                                                     </div>
                                                 </div>
                                                <div class="form-group row">
                                                    <div class="col-lg-offset-2 col-lg-12">
                                                        <?php if(!@empty($id)): ?>
                                                        <button class="btn btn-sm btn-primary float-right m-t-n-xs"
                                                            data-toggle="modal" data-target="#myModal"
                                                            type="submit">Update</button>
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
</section>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    var loadBigFile=function(event){
      var output=document.getElementById('big_output');
      output.src=URL.createObjectURL(event.target.files[0]);
    };
  </script>
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


$('.demo4').click(function() {
    swal({
        title: "Are you sure?",
        text: "You will not be able to recover this imaginary file!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, delete it!",
        closeOnConfirm: false
    }, function() {
        swal("Deleted!", "Your imaginary file has been deleted.", "success");
    });
});
</script>
<script src="<?php echo e(url('assets/js/plugins/sweetalert/sweetalert.min.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/admin/web/del.co.tz/public_html/resources/views/driver/driver.blade.php ENDPATH**/ ?>