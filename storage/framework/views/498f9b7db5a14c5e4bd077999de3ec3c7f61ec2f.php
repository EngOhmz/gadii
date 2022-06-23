<?php $__env->startSection('content'); ?>
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Costants</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link <?php if(empty($id)): ?> active show <?php endif; ?>" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Costants</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php if(!empty($id)): ?> active show <?php endif; ?>" id="profile-tab2"
                                    data-toggle="tab" href="#profile2" role="tab" aria-controls="profile"
                                    aria-selected="false">New Costants</a>
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
                                                    style="width: 208.531px;">#</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Cotton in Kg</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Seeds in Kg</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                       rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Raw Cotton in Kg</th> 
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Dust in Kg</th>
                                         
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if(!@empty($costants)): ?>
                                            <?php $__currentLoopData = $costants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr class="gradeA even" role="row">
                                                <th><?php echo e($loop->iteration); ?> Kg</th>
                                                <td><?php echo e($row->cotton); ?> Kg</td>
                                                <td><?php echo e($row->seeds); ?> Kg</td>
                                              <td> <?php echo e($row->raw_cotton); ?> Kg</td>
                                           <td> <?php echo e($row->dust); ?> Kg</td>                         
                                              
                                                <td>

                                                    <a class="btn btn-xs btn-outline-info text-uppercase px-2 rounded"
                                                        href="<?php echo e(route("costants.edit", $row->id)); ?>">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <a class="btn btn-xs btn-outline-danger text-uppercase px-2 rounded demo4"
                                                        href="<?php echo e(route("costants.destroy", $row->id)); ?>">
                                                        <i class="fa fa-trash"></i>
                                                    </a>


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
                                            <h5>Edit costants</h5>
                                            <?php else: ?>
                                            <h5>Add New costants</h5>
                                            <?php endif; ?>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">
                                            <?php if(isset($id)): ?>
                                                    <?php echo e(Form::model($id, array('route' => array('costants.update', $id), 'method' => 'PUT'))); ?>

                                                    <?php else: ?>
                                                    <?php echo e(Form::open(['route' => 'costants.store'])); ?>

                                                    <?php echo method_field('POST'); ?>
                                                    <?php endif; ?>

                                                    <div class="form-group row"><label
                                                            class="col-lg-2 col-form-label">Cotton in Kg <span class="required" style="color:red;"> * </span></label>

                                                        <div class="col-lg-10">
                                                            <input type="text" name="cotton"
                                                                value="<?php echo e(isset($data) ? $data->cotton : ''); ?>"
                                                                class="form-control" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row"><label
                                                            class="col-lg-2 col-form-label">Seeds in Kg </label>

                                                        <div class="col-lg-10">
                                                            <input type="text" name="seeds"
                                                                value="<?php echo e(isset($data) ? $data->seeds : ''); ?>"
                                                                class="form-control"  required>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row"><label
                                                            class="col-lg-2 col-form-label">Raw Cotton in Kg </label>

                                                        <div class="col-lg-10">
                                                            <input type="text" name="raw_cotton"
                                                                value="<?php echo e(isset($data) ? $data->raw_cotton : ''); ?>"
                                                                class="form-control" >
                                                        </div>
                                                    </div>

                                                <div class="form-group row"><label
                                                            class="col-lg-2 col-form-label">Dust in Kg </label>

                                                        <div class="col-lg-10">
                                                            <textarea name="dust"  class="form-control">  <?php echo e(isset($data) ? $data->dust : ''); ?> </textarea>
                                                                                                                    

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
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/admin/web/gaki.ema.co.tz/public_html/resources/views/cotton/costants.blade.php ENDPATH**/ ?>