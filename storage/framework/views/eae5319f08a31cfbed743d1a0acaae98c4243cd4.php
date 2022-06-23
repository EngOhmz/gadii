<?php $__env->startSection('content'); ?>
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Good Reallocation</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link <?php if(empty($id)): ?> active show <?php endif; ?>" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Good Reallocation
                                    List</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php if(!empty($id)): ?> active show <?php endif; ?>" id="profile-tab2"
                                    data-toggle="tab" href="#profile2" role="tab" aria-controls="profile"
                                    aria-selected="false">New Good Reallocation</a>
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
                                                    style="width: 141.219px;">Item Name</th>
                                                 
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
                                                    style="width: 98.1094px;">Mechanical</th>
                                                   
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
                                                <td>
                                                    <?php    
                                                    $it=App\Models\InventoryList::where('id', $row->source_item)->get();   
                                                  ?>
                                                     <?php $__currentLoopData = $it; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                     <?php echo e($i->serial_no); ?>

                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </td>
                                               
                                          
                                                <td>
                                                    <?php    
                                                    $tr=App\Models\Truck::where('id', $row->source_truck)->get();   
                                                  ?>
                                                     <?php $__currentLoopData = $tr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                     <?php echo e($t->truck_name); ?> - <?php echo e($t->reg_no); ?>

                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </td>
                                                    
                                                <td>
                                                   
                                                    <?php
                                                         
                                                    $dr=App\Models\Truck::where('id', $row->destination_truck)->get();   
                                                  ?>
                                                     <?php $__currentLoopData = $dr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                     <?php echo e($d->truck_name); ?> - <?php echo e($d->reg_no); ?>

                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                      
                                                </td>

                                                <td>
                                                    <?php    
                                                    $st=App\Models\FieldStaff::where('id', $row->staff)->get();   
                                                  ?>
                                                     <?php $__currentLoopData = $st; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php echo e($s->name); ?>

                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </td>

                                                      <td>
                                                  <?php if($row->status == 0): ?>
                                                          <a class="btn btn-xs btn-outline-primary text-uppercase px-2 rounded"
                                                    href="<?php echo e(route("reallocation.approve", $row->id)); ?>" title="Approve" onclick="return confirm('Are you sure?')">
                                                    <i class="fa fa-check"></i>
                                                </a>

                                                    <a class="btn btn-xs btn-outline-info text-uppercase px-2 rounded"
                                                        href="<?php echo e(route("good_reallocation.edit", $row->id)); ?>">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                   
                                                    <?php echo Form::open(['route' => ['good_reallocation.destroy',$row->id],
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
                                        <h5>Edit Good Reallocation</h5>
                                        <?php else: ?>
                                        <h5>Add New Good Reallocation</h5>
                                        <?php endif; ?>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">
                                                     <?php if(isset($id)): ?>
                                                <?php echo e(Form::model($id, array('route' => array('good_reallocation.update', $id), 'method' => 'PUT'))); ?>

                                                <?php else: ?>
                                                <?php echo e(Form::open(['route' => 'good_reallocation.store'])); ?>

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
                                                        <select class="form-control source" name="source_truck" required
                                                                id="">
                                                        <option value="">Select Source</option>
                                                        <?php if(!empty($truck)): ?>
                                                        <?php $__currentLoopData = $truck; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                        <option <?php if(isset($data)): ?>
                                                            <?php echo e($data->source_truck == $row->id  ? 'selected' : ''); ?>

                                                            <?php endif; ?> value="<?php echo e($row->id); ?>"><?php echo e($row->truck_name); ?> - <?php echo e($row->reg_no); ?></option>

                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php endif; ?>

                                                    </select>
                                                    </div>
                                                
                                                    <label
                                                    class="col-lg-2 col-form-label">Destination Truck</label>

                                                <div class="col-lg-4">
                                                    <select class="form-control destination" name="destination_truck" required
                                                    id="">
                                                    <option value="">Select Destination</option>
                                                    <?php if(!empty($truck)): ?>
                                                    <?php $__currentLoopData = $truck; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                    <option <?php if(isset($data)): ?>
                                                        <?php echo e($data->destination_truck == $row->id  ? 'selected' : ''); ?>

                                                        <?php endif; ?> value="<?php echo e($row->id); ?>"><?php echo e($row->truck_name); ?>  - <?php echo e($row->reg_no); ?></option>

                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php endif; ?>
                                            </select>
                                                    </div>
                                                </div>
                                          
                                              <div class="form-group row">
                <label class="col-lg-2 col-form-label">Source Item Name</label>

                <div class="col-lg-4">
                  <?php if(!empty($data->source_item)): ?>
                                   <select id="source_item" name="source_item" class="form-control item" required>
                                      <option value="">Select Source Item Name</option>
                                       <?php $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $l): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                  <option value="<?php echo e($l->id); ?>" <?php if(isset($data)): ?><?php if($data->source_item == $l->id): ?> selected <?php endif; ?> <?php endif; ?> ><?php echo e($l->serial_no); ?> </option>
                                   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                   <?php else: ?>                              
                                  <select id="source_item" name="source_item" class="form-control item" required>
                                     <option value="">Select Source Item Name</option>
                                    
                                    </select>
                                   <?php endif; ?> 
                    
                </div>

 <label class="col-lg-2 col-form-label">Destination Item Name</label>

                <div class="col-lg-4">
                  <?php if(!empty($data->destination_item)): ?>
                                   <select id="destination_item" name="destination_item" class="form-control dest_item">
                                      <option >Select Destination Item Name</option>
                                       <?php $__currentLoopData = $dest_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d_l): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                  <option value="<?php echo e($d_l->id); ?>" <?php if(isset($data)): ?><?php if($data->destination_item == $d_l->id): ?> selected <?php endif; ?> <?php endif; ?> ><?php echo e($d_l->serial_no); ?> </option>
                                   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                   <?php else: ?>                              
                                    <select id="destination_item" name="destination_item" class="form-control dest_item">
                                      <option value="">Select Destination Item Name</option>
                                    
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
    
    
        $(document).on('change', '.source', function() {
            var id = $(this).val();
            $.ajax({
                url: '<?php echo e(url("findReturnService")); ?>',
                type: "GET",
                data: {
                    id: id
                },
                dataType: "json",
                success: function(data) {
                    console.log(data);
                    $("#source_item").empty();
                $("#source_item").append('<option value="">Select Source Item Name</option>');
                $.each(data,function(key, value)
                {
                 
                    $("#source_item").append('<option value=' + value.id+ '>' + value.serial_no + '</option>');
                   
                });
                }
    
            });
    
        });
    
    
    });
    </script>
    
  <script>
    $(document).ready(function() {
    
    
        $(document).on('change', '.destination', function() {
            var id = $(this).val();
            $.ajax({
                url: '<?php echo e(url("findReturnService")); ?>',
                type: "GET",
                data: {
                    id: id
                },
                dataType: "json",
                success: function(data) {
                    console.log(data);
                    $("#destination_item").empty();
                $("#destination_item").append('<option value="">Select Destination Item Name</option>');
                $.each(data,function(key, value)
                {
                 
                    $("#destination_item").append('<option value=' + value.id+ '>' + value.serial_no + ' </option>');
                   
                });
                }
    
            });
    
        });
    
    
    });
    </script>

<script src="<?php echo e(url('assets/js/plugins/sweetalert/sweetalert.min.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/admin/web/del.co.tz/public_html/resources/views/inventory/good_reallocation.blade.php ENDPATH**/ ?>