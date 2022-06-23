<?php $__env->startSection('content'); ?>
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Training</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                         
                                <a class="nav-link <?php if(empty($id)): ?> active show <?php endif; ?>" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Training
                                    List</a>
                            </li>
                           
                            <li class="nav-item">
                                <a class="nav-link <?php if(!empty($id)): ?> active show <?php endif; ?>" id="profile-tab2"
                                    data-toggle="tab" href="#profile2" role="tab" aria-controls="profile"
                                    aria-selected="false">New Training</a>
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
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 186.484px;">#</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 186.484px;">Staff Name</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 186.484px;">Course/Training</th>
                                                     <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 186.484px;">Vendor</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Duration</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Status</th>


                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if(!@empty($training)): ?>
                                            <?php $__currentLoopData = $training; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr class="gradeA even" role="row">

                                                <td>
                                                    <?php echo e($loop->iteration); ?>

                                                </td>
                                                <td><?php echo e($row->staff->name); ?></td>
                                                <td><?php echo e($row->training_name); ?></td>
                                                 <td><?php echo e($row->vendor_name); ?></td>

                                                 <td>
                                                    
                                                    <?php echo e(Carbon\Carbon::parse($row->start_date)->format('d/m/Y')); ?> - <?php echo e(Carbon\Carbon::parse($row->end_date)->format('d/m/Y')); ?> 
                                        
                                                </td>

                                                 <td>
                                                    <?php if($row->status== 0): ?>
                                                    <div class="badge badge-warning badge-shadow">Pending</div>
                                                    <?php elseif($row->status == 1): ?>
                                                    <div class="badge badge-info badge-shadow">Started</div>
                                                    <?php elseif($row->status == 2): ?>
                                                    <div class="badge badge-success badge-shadow">Completed</div>
                                                     <?php elseif($row->status == 3): ?>
                                                    <div class="badge badge-danger badge-shadow">Terminated</div>

                                                    <?php endif; ?>
                                                </td>
                                               
                                               

                                                <td>
                                                   <?php if($row->status == 1 || $row->status == 0): ?>
                                                    <a class="btn btn-xs btn-outline-info text-uppercase px-2 rounded"
                                                        title="Edit" onclick="return confirm('Are you sure?')"
                                                        href="<?php echo e(route('training.edit', $row->id)); ?>"><i
                                                            class="fa fa-edit"></i></a>
                                                           

                                                    <?php echo Form::open(['route' => ['training.destroy',$row->id],
                                                    'method' => 'delete']); ?>

                                                    <?php echo e(Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-xs btn-outline-danger text-uppercase px-2 rounded demo4', 'title' => 'Delete', 'onclick' => "return confirm('Are you sure?')"])); ?>

                                                    <?php echo e(Form::close()); ?>


                                                      
                                                    <div class="btn-group">
                                                        <button class="btn btn-xs btn-success dropdown-toggle"
                                                            data-toggle="dropdown">Change Status<span
                                                                class="caret"></span></button>
                                                        <ul class="dropdown-menu animated zoomIn">
                                                            
                                                            <li class="nav-item"><a class="nav-link"  onclick="return confirm('Are you sure?')"
                                                              href="<?php echo e(route('training.start',$row->id)); ?>">Started
                                                                    </a></li>   
                                                                 
                                                            <li class="nav-item"><a class="nav-link"  onclick="return confirm('Are you sure?')"
                                                              href="<?php echo e(route('training.approve',$row->id)); ?>">Completed
                                                                    </a></li>                          
                                                                  

                                                                   
                                                                       <li class="nav-item"><a class="nav-link" href="<?php echo e(route('training.reject',$row->id)); ?>"
                                                                        role="tab"
                                                                        aria-selected="false" onclick="return confirm('Are you sure?')">Terminated
                                                                            </a></li>
                                                                           
                                                        </ul>
                                                    </div>
                                                    <?php endif; ?>

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
                                        <h5>Create Training</h5>
                                        <?php else: ?>
                                        <h5>Edit Training</h5>
                                        <?php endif; ?>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">
                                                <?php if(isset($id)): ?>
                                                <?php echo e(Form::model($id, array('route' => array('training.update', $id), 'method' => 'PUT'))); ?>

                                                <?php else: ?>
                                                <?php echo e(Form::open(['route' => 'training.store'])); ?>

                                                <?php echo method_field('POST'); ?>
                                                <?php endif; ?>




                                                <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Staff</label>
                                                    <div class="col-lg-4">
                                                        <select class="form-control" name="staff_id" required
                                                        id="supplier_id">
                                                        <option value="">Select</option>
                                                        <?php if(!empty($staff)): ?>
                                                        <?php $__currentLoopData = $staff; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                        <option <?php if(isset($data)): ?>
                                                            <?php echo e($data->staff_id == $row->id  ? 'selected' : ''); ?>

                                                            <?php endif; ?> value="<?php echo e($row->id); ?>"><?php echo e($row->name); ?></option>

                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php endif; ?>

                                                    </select>
                                                    </div>
                                                    <label class="col-lg-2 col-form-label">Course/Training</label>
                                                    <div class="col-lg-4">
                                                        
                                                            <input type="text" name="training_name"  value="<?php echo e(isset($data) ? $data->training_name: ''); ?>"
                                                            class="form-control" required>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Vendor</label>
                                                    <div class="col-lg-4">
                                                        <input type="text" name="vendor_name"  value="<?php echo e(isset($data) ? $data->vendor_name: ''); ?>"
                                                            class="form-control" required>
                                                    </div>



                                                <label class="col-lg-2 col-form-label">Start Date</label>
                                                    <div class="col-lg-4">
                                                        <input type="date"  name="start_date"
                                                            placeholder=""
                                                            value="<?php echo e(isset($data) ? $data->start_date : ''); ?>"
                                                            class="form-control" required>
                                                    </div>

                                                   
                                                </div>

                                        
                                         <div class="form-group row end">
                                                    <label class="col-lg-2 col-form-label">End Date</label>
                                                    <div class="col-lg-4">
                                                        <input type="date"  name="end_date"
                                                            placeholder=""
                                                            value="<?php echo e(isset($data) ? $data->end_date : ''); ?>"
                                                            class="form-control" required>
                                                    </div>
                                           <label class="col-lg-2 col-form-label">Performance</label>
                                                    <div class="col-lg-4">
                                                        
                                                            <select class="form-control" name="performance" 
                                                                id="route">
                                                               <option value="0" <?php if(isset($data)): ?><?php echo e($data->performance == '0'  ? 'selected' : ''); ?>  <?php endif; ?> >Not Concluded</option>
                                                                                    <option value="1" <?php if(isset($data)): ?><?php echo e($data->performance == '1'  ? 'selected' : ''); ?>  <?php endif; ?> >Satisfactory</option>
                                                                                    <option value="2" <?php if(isset($data)): ?><?php echo e($data->performance == '2'  ? 'selected' : ''); ?>  <?php endif; ?> >Average</option> 
                                                                                    <option value="3" <?php if(isset($data)): ?><?php echo e($data->performance == '3'  ? 'selected' : ''); ?>  <?php endif; ?> >Poor</option>
                                                                                    <option value="4" <?php if(isset($data)): ?><?php echo e($data->performance  == '4'  ? 'selected' : ''); ?>  <?php endif; ?> >Excellent</option>
                                                                                   

                                                            </select>
                                                           
                                                    </div>
                                            </div>
                                         

                                            
                                         

                                         
                                                 <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Remarks</label>
                                                    <div class="col-lg-4">
                                                       <textarea id="present" name="remarks" class="form-control" rows="6" data-parsley-id="25"><?php echo e(isset($data) ? $data->reason : ''); ?></textarea>
                                                    </div>
                                                    <label class="col-lg-2 col-form-label">Attachment</label>
                                                    <div class="col-lg-4">
                                                        
                                                           <input type="file" name="attachment" class="form-control"
                                                                id="attachment"
                                                                value=" "
                                                                placeholder="">
                                                          
                                                    </div>
                                                </div>

                                              <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Training Cost</label>
                                                    <div class="col-lg-4">
                                                        <input type="number"  steps="0.01" name="training_cost"  value="<?php echo e(isset($data) ? $data->training_cost: ''); ?>"
                                                            class="form-control" required>
                                                    </div>
                                                      </div>
                                                
                                                <div class="form-group row">
                                                    <div class="col-lg-offset-2 col-lg-12">
                                                        <?php if(!@empty($id)): ?>

                                                        <a class="btn btn-sm btn-danger float-right m-t-n-xs"
                                                            href="<?php echo e(route('training.index')); ?>">
                                                           Cancel
                                                        </a>
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
</script>
<script src="<?php echo e(url('assets/js/plugins/sweetalert/sweetalert.min.js')); ?>"></script>








  




<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/admin/web/del.co.tz/public_html/resources/views/training/training.blade.php ENDPATH**/ ?>