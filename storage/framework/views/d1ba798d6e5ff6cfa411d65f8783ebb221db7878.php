<?php $__env->startSection('content'); ?>
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Tire Reallocation</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link <?php if(empty($id)): ?> active show <?php endif; ?>" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Tire Reallocation
                                    List</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php if(!empty($id)): ?> active show <?php endif; ?>" id="profile-tab2"
                                    data-toggle="tab" href="#profile2" role="tab" aria-controls="profile"
                                    aria-selected="false">New Tire Reallocation</a>
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
                                                        aria-label="Engine version: activate to sort column ascending"
                                                        style="width: 141.219px;">Source Truck</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Destination Truck</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Allocated by</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Status</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if(!@empty($reallocation)): ?>
                                            <?php $__currentLoopData = $reallocation; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr class="gradeA even" role="row">
                                                <th><?php echo e($loop->iteration); ?></th>
                                                <td><?php echo e(Carbon\Carbon::parse($row->date)->format('M d, Y')); ?></td>
                                                <td><?php echo e($row->tyre_no->reference); ?></td> 
                                                <td><?php echo e($row->s_truck->reg_no); ?> - <?php echo e($row->s_truck->truck_name); ?></td> 
                                                <td><?php echo e($row->d_truck->reg_no); ?> - <?php echo e($row->d_truck->truck_name); ?></td>
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
                                                        href="<?php echo e(route("tyre_reallocation.edit", $row->id)); ?>">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <a class="btn btn-xs btn-outline-primary text-uppercase px-2 rounded"
                                                    href="<?php echo e(route("tyre_reallocation.approve", $row->id)); ?>" title="Approve" onclick="return confirm('Are you sure?')">
                                                    <i class="fa fa-check"></i>
                                                </a>
                                               
                                                    <?php echo Form::open(['route' => ['tyre_reallocation.destroy',$row->id],
                                                    'method' => 'delete']); ?>

                                                    <?php echo e(Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-xs btn-outline-danger text-uppercase px-2 rounded demo4', 'title' => 'Delete', 'onclick' => "return confirm('Are you sure?')"])); ?>

                                                    <?php echo e(Form::close()); ?>

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
                                        <?php if(!empty($id)): ?>
                                        <h5>Edit Tire Reallocation</h5>
                                        <?php else: ?>
                                        <h5>Add New Tire Reallocation</h5>
                                        <?php endif; ?>
                                    </div>

                                     
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">
                                              <h6>NOTE: CHOOSE TIRES WITH THE SAME POSTION</h6><br>
                                                     <?php if(isset($id)): ?>
                                                <?php echo e(Form::model($id, array('route' => array('tyre_reallocation.update', $id), 'method' => 'PUT'))); ?>

                                                <?php else: ?>
                                                <?php echo e(Form::open(['route' => 'tyre_reallocation.store'])); ?>

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
                                                    <label class="col-lg-2 col-form-label">Source Truck</label>
                                                    <div class="col-lg-4">
                                                        <select class="form-control truck_id" name="source_truck" required
                                                                id="supplier_id">
                                                        <option value="">Select Source</option>
                                                        <?php if(!empty($truck_s)): ?>
                                                        <?php $__currentLoopData = $truck_s; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                        <option <?php if(isset($data)): ?>
                                                            <?php echo e($data->source_truck == $row->id  ? 'selected' : ''); ?>

                                                            <?php endif; ?> value="<?php echo e($row->id); ?>"><?php echo e($row->truck->reg_no); ?> - <?php echo e($row->truck->truck_name); ?></option>

                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php endif; ?>

                                                    </select>
                                                    </div>
                                                
                                                    <label
                                                    class="col-lg-2 col-form-label">Destination Truck</label>

                                                <div class="col-lg-4">
                                                    <select class="form-control type_id" name="destination_truck" required
                                                    id="">
                                                    <option value="">Select Destination</option>
                                                    <?php if(!empty($truck)): ?>
                                                    <?php $__currentLoopData = $truck; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                    <option <?php if(isset($data)): ?>
                                                        <?php echo e($data->destination_truck == $row->id  ? 'selected' : ''); ?>

                                                        <?php endif; ?> value="<?php echo e($row->id); ?>"><?php echo e($row->truck->reg_no); ?> - <?php echo e($row->truck->truck_name); ?></option>

                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php endif; ?>
                                            </select>
                                                    </div>
                                                </div>
                                          
                                               
                                        <div class="form-group row">
                <label class="col-lg-2 col-form-label">Source Reading</label>

                <div class="col-lg-4">
                 <input type="text" name="source_reading" value="<?php echo e(isset($data) ? $data->source_reading : ''); ?> "   class="form-control"  required>
                    
                </div>

               <label class="col-lg-2 col-form-label">Destination Reading</label>

                <div class="col-lg-4">
                 <input type="text" name="destination_reading" value="<?php echo e(isset($data) ? $data->destination_reading : ''); ?>"   class="form-control"  required>
                    
                </div>
            </div>    



                                      <div class="form-group row">
                <label class="col-lg-2 col-form-label">Source Tire</label>

                <div class="col-lg-4">
                  <?php if(!empty($data->tyre_id)): ?>
                                   <select id="tyre" name="tyre_id" class="form-control tyre">
                                      <option >Select Source Tire</option>
                                       <?php $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $l): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                  <option value="<?php echo e($l->id); ?>" <?php if(isset($data)): ?><?php if($data->tyre_id == $l->id): ?> selected <?php endif; ?> <?php endif; ?> ><?php echo e($l->reference); ?> </option>
                                   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                   <?php else: ?>                              
                                  <select id="tyre" name="tyre_id" class="form-control tyre">
                                      <option >Select Tire</option>
                                    
                                    </select>
                                   <?php endif; ?> 
                    
                </div>

 <label class="col-lg-2 col-form-label">Destination Tire</label>

                <div class="col-lg-4">
                  <?php if(!empty($data->destination_tyre)): ?>
                                   <select id="destination_tyre" name="destination_tyre" class="form-control dest_tyre">
                                      <option >Select Destination Tire</option>
                                       <?php $__currentLoopData = $dest_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d_l): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                  <option value="<?php echo e($d_l->id); ?>" <?php if(isset($data)): ?><?php if($data->destination_tyre == $d_l->id): ?> selected <?php endif; ?> <?php endif; ?> ><?php echo e($d_l->reference); ?> </option>
                                   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                   <?php else: ?>                              
                                  <select id="destination_tyre" name="destination_tyre" class="form-control dest_tyre">
                                      <option value="">Select Destination Tire</option>
                                    
                                    </select>
                                   <?php endif; ?> 
                    
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
<script>
    $(document).ready(function() {
    
    
        $(document).on('change', '.truck_id', function() {
            var id = $(this).val();
            $.ajax({
                url: '<?php echo e(url("findTyreDetails")); ?>',
                type: "GET",
                data: {
                    id: id
                },
                dataType: "json",
                success: function(data) {
                    console.log(data);
                    $("#tyre").empty();
                $("#tyre").append('<option value="">Select Source Tire</option>');
                $.each(data,function(key, value)
                {
                 
                    $("#tyre").append('<option value=' + value.id+ '>' + value.reference + ' - ' + value.position + ' Position</option>');
                   
                });
                }
    
            });
    
        });
    
    
    });
    </script>
    
  <script>
    $(document).ready(function() {
    
    
        $(document).on('change', '.type_id', function() {
            var id = $(this).val();
            $.ajax({
                url: '<?php echo e(url("findTyreDetails")); ?>',
                type: "GET",
                data: {
                    id: id
                },
                dataType: "json",
                success: function(data) {
                    console.log(data);
                    $("#destination_tyre").empty();
                $("#destination_tyre").append('<option value="">Select Destination Tire</option>');
                $.each(data,function(key, value)
                {
                 
                    $("#destination_tyre").append('<option value=' + value.id+ '>' + value.reference + ' - ' + value.position + ' Position</option>');
                   
                });
                }
    
            });
    
        });
    
    
    });
    </script>

<script src="<?php echo e(url('assets/js/plugins/sweetalert/sweetalert.min.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/admin/web/del.co.tz/public_html/resources/views/tyre/good_reallocation.blade.php ENDPATH**/ ?>