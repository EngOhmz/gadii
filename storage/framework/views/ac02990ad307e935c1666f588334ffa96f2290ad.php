<?php $__env->startSection('content'); ?>
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>System Settings</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link <?php if(empty($id)): ?> active show <?php endif; ?>" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">System Settings
                                    List</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php if(!empty($id)): ?> active show <?php endif; ?>" id="profile-tab2"
                                    data-toggle="tab" href="#profile2" role="tab" aria-controls="profile"
                                    aria-selected="false">New System Settings</a>
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
                                                    style="width: 186.484px;">Systam Name</th>
                                                      <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 186.484px;">Email</th>
                                                      <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 186.484px;">Phone</th>
                                                      <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 186.484px;">Address</th>
                                                      <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 186.484px;">VAT</th>
                                                      <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 186.484px;">TIN</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 186.484px;">System Logo</th>
                                               
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Actions</th>
                                            </tr>
                                        </thead>
                                         <tbody>
                                            <?php if(!@empty($system)): ?>
                                            <?php $__currentLoopData = $system; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr class="gradeA even" role="row">
                                                <th><?php echo e($loop->iteration); ?></th>
                                                <td><?php echo e($row->name); ?></td>
                                                <td><?php echo e($row->email); ?></td>
                                                <td><?php echo e($row->address); ?></td>
                                                <td><?php echo e($row->phone); ?></td>
                                                <td><?php echo e($row->vat); ?></td>
                                                <td><?php echo e($row->tin); ?></td>
                                                <td><img src="<?php echo e(url('public/assets/img/logo')); ?>/<?php echo e($row->picture); ?>" alt="<?php echo e($row->name); ?>" width="50"></td>

                                              

                                                <td>
                                                    <div class="row">
                                                       
                                                        <div class="col-lg-6">
<a class="btn btn-icon btn-info" title="Edit" onclick="return confirm('Are you sure?')"   href="<?php echo e(route("system.edit", $row->id)); ?>"><i class="fa fa-edit"></i></a>
                                                        </div>
                                                     
                                                        <div class="col-lg-6">
                                                            <?php echo Form::open(['route' => ['system.destroy',$row->id], 'method' => 'delete']); ?>

                                                            <?php echo e(Form::button('<i class="fas fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-icon btn-danger', 'onclick' => "return confirm('Are you sure?')"])); ?>

                                                            <?php echo e(Form::close()); ?>

                                                        </div>
                                                     
                                                    </div>
                                                  

                                             

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
                                        <?php if(empty($id)): ?>
                                        <h5>Create System Settings</h5>
                                        <?php else: ?>
                                        <h5>Edit System Settings</h5>
                                        <?php endif; ?>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">
                                                <?php if(isset($id)): ?>
                                                <?php echo e(Form::model($id, array('route' => array('system.update', $id), 'method' => 'PUT',"enctype"=>"multipart/form-data"))); ?>

                                                <?php else: ?>
                                                <?php echo Form::open(array('route' => 'system.store',"enctype"=>"multipart/form-data")); ?>

                                                <?php echo method_field('POST'); ?>
                                                <?php endif; ?>



                                                <div class="form-group row">
                           <label class="col-lg-2 col-form-label">System Name</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" name="name" required
                                                            value="<?php echo e(isset($data) ? $data->name : ''); ?>"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                                
                                                    <div class="form-group row">
                           <label class="col-lg-2 col-form-label">VAT</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" name="vat" required
                                                            value="<?php echo e(isset($data) ? $data->vat : ''); ?>"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                                    <div class="form-group row">
                           <label class="col-lg-2 col-form-label">TIN</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" name="tin" required
                                                            value="<?php echo e(isset($data) ? $data->tin : ''); ?>"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                                    <div class="form-group row">
                           <label class="col-lg-2 col-form-label">Email</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" name="email" required
                                                            value="<?php echo e(isset($data) ? $data->email : ''); ?>"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                                    <div class="form-group row">
                           <label class="col-lg-2 col-form-label">Phone</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" name="phone" required
                                                            value="<?php echo e(isset($data) ? $data->phone : ''); ?>"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                                    <div class="form-group row">
                           <label class="col-lg-2 col-form-label">Address</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" name="address" required
                                                            value="<?php echo e(isset($data) ? $data->address : ''); ?>"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                                

                                               <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">System Logo</label>
                                                    <div class="col-lg-8">
                                                          <?php if(!@empty($data->picture)): ?>
                  <img src="<?php echo e(url('public/assets/img/logo')); ?>/<?php echo e($data->picture); ?>" alt="<?php echo e($data->name); ?>" width="100">
   <input  type="file" name="picture" required value="<?php echo e($data->picture); ?>" class="form-control" onchange="loadBigFile(event)">
<?php else: ?>
 <input  type="file" name="picture" required  class="form-control" onchange="loadBigFile(event)">
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
</script>
<script src="<?php echo e(url('assets/js/plugins/sweetalert/sweetalert.min.js')); ?>"></script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/admin/web/gaki.ema.co.tz/public_html/resources/views/system/data.blade.php ENDPATH**/ ?>