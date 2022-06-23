<?php $__env->startSection('content'); ?>
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Good Disposal</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link <?php if(empty($id)): ?> active show <?php endif; ?>" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Good Disposal
                                    List</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php if(!empty($id)): ?> active show <?php endif; ?>" id="profile-tab2"
                                    data-toggle="tab" href="#profile2" role="tab" aria-controls="profile"
                                    aria-selected="false">New Good Disposal</a>
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
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 186.484px;">Date</th>
                                               
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Tyre</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Location</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Disposed by</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Status</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if(!@empty($disposal)): ?>
                                            <?php $__currentLoopData = $disposal; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr class="gradeA even" role="row">
                                                <th><?php echo e($loop->iteration); ?></th>
                                                <td><?php echo e(Carbon\Carbon::parse($row->date)->format('M d, Y')); ?></td>
                                                <td><?php echo e($row->tyre_no->serial_no); ?></td>                                              
                                                <td><?php echo e($row->tyre_location->name); ?></td>                                             
                                                <td><?php echo e($row->tyre_staff->name); ?></td> 

                                                <td>
                                                    <?php if($row->status == 0): ?>
                                                    <div class="badge badge-danger badge-shadow">Not Approved</div>
                                              
                                                    <?php elseif($row->status == 1): ?>
                                                    <span class="badge badge-success badge-shadow"> Approved</span>

                                                    <?php endif; ?>
                                                </td>
                                                      <td>
                                                        <?php if($row->status == 0): ?>
                                                    <a class="btn btn-xs btn-outline-info text-uppercase px-2 rounded"
                                                        href="<?php echo e(route("tyre_disposal.edit", $row->id)); ?>">
                                                        <i class="fa fa-edit"></i>
                                                    </a>

                                                    <a class="btn btn-xs btn-outline-primary text-uppercase px-2 rounded"
                                                    href="<?php echo e(route("tyre_disposal.approve", $row->id)); ?>" title="Approve" onclick="return confirm('Are you sure?')">
                                                    <i class="fa fa-check"></i>
                                                </a>
                                                <?php endif; ?>
                                                    <?php echo Form::open(['route' => ['tyre_disposal.destroy',$row->id],
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
                                        <h5>Edit Good Disposal</h5>
                                        <?php else: ?>
                                        <h5>Add New Good Disposal</h5>
                                        <?php endif; ?>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">
                                                     <?php if(isset($id)): ?>
                                                <?php echo e(Form::model($id, array('route' => array('tyre_disposal.update', $id), 'method' => 'PUT'))); ?>

                                                <?php else: ?>
                                                <?php echo e(Form::open(['route' => 'tyre_disposal.store'])); ?>

                                                <?php echo method_field('POST'); ?>
                                                <?php endif; ?>

                                                <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Date</label>
                                                    <div class="col-lg-4">
                                                        <input type="date" name="date"
                                                            placeholder="0 if does not exist"
                                                            value="<?php echo e(isset($data) ? $data->date : ''); ?>"
                                                            class="form-control" required>
                                                    </div>
                                                    <label class="col-lg-2 col-form-label">Mechanical</label>
                                                    <div class="col-lg-4">
                                                     <select class="form-control type" name="staff" required
                                                         id="">
                                                 <option value="">Select 
                                                    <?php if(!empty($staff)): ?>
                                                    <?php $__currentLoopData = $staff; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                    <option <?php if(isset($data)): ?>
                                                        <?php echo e($data->staff == $row->id  ? 'selected' : ''); ?>

                                                        <?php endif; ?> value="<?php echo e($row->id); ?>"><?php echo e($row->name); ?></option>

                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php endif; ?>                                              
 
                                             </select>
                                                   
                                                </div>
                                            </div>

                                                

                                               
                                          
                                                <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Tyre</label>
                                                    <div class="col-lg-4">

                                                         <select name="tyre_id"
                                                            class="form-control item_name" required
                                                            >
                                                            <option value="">Select Item</option><?php $__currentLoopData = $inventory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <option value="<?php echo e($n->id); ?>"
                                                                <?php if(isset($data)): ?><?php if($n->id == $data->tyre_id): ?>
                                                                selected <?php endif; ?> <?php endif; ?> ><?php echo e($n->reference); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>
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
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/admin/web/gaki.ema.co.tz/public_html/resources/views/tyre/good_disposal.blade.php ENDPATH**/ ?>