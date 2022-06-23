<?php $__env->startSection('content'); ?>
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Good Issue</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link <?php if(empty($id)): ?> active show <?php endif; ?>" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Good Issue
                                    List</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php if(!empty($id)): ?> active show <?php endif; ?>" id="profile-tab2"
                                    data-toggle="tab" href="#profile2" role="tab" aria-controls="profile"
                                    aria-selected="false">New Good Issue</a>
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
                                                    style="width: 141.219px;">Location</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Type</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Service/Maintainance</th>
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
                                            <?php if(!@empty($issue)): ?>
                                            <?php $__currentLoopData = $issue; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr class="gradeA even" role="row">
                                                <th><?php echo e($loop->iteration); ?></th>
                                                <td><?php echo e(Carbon\Carbon::parse($row->date)->format('M d, Y')); ?></td>
                                                <td>
                                                    <?php    
                                                    $tr=App\Models\Location::where('id', $row->location)->get();   
                                                  ?>
                                                     <?php $__currentLoopData = $tr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                     <?php echo e($t->name); ?>

                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </td>
                                                <td>
                                   
                                                    <?php echo e($row->type); ?>

                                                   
                                                </td>
                                                    
                                                <td>
                                                    <?php if($row->type == 'Service'): ?>
                                                    <?php
                                                        $service= App\Models\Service::where('id',$row->type_id)->first();
                                                        ?>
                                                         <?php echo e($service->truck_name); ?> -  <?php echo e($service->reg_no); ?>

                                                       <?php elseif($row->type == 'Maintenance'): ?>
                                                       <?php
                                                           $maintain=App\Models\Maintainance::where('id',$row->type_id)->first();
                                                           ?>
                                                         <?php echo e($maintain->truck_name); ?> -  <?php echo e($maintain->reg_no); ?>

                                                   <?php endif; ?>
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
                                                    href="<?php echo e(route("issue.approve", $row->id)); ?>" title="Approve" onclick="return confirm('Are you sure?')">
                                                    <i class="fa fa-check"></i>
                                                </a>

                                                    <a class="btn btn-xs btn-outline-info text-uppercase px-2 rounded"
                                                        href="<?php echo e(route("good_issue.edit", $row->id)); ?>">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                   
                                                    <?php echo Form::open(['route' => ['good_issue.destroy',$row->id],
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
                                        <h5>Edit Good Issue</h5>
                                        <?php else: ?>
                                        <h5>Add New Good Issue</h5>
                                        <?php endif; ?>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">
                                                     <?php if(isset($id)): ?>
                                                <?php echo e(Form::model($id, array('route' => array('good_issue.update', $id), 'method' => 'PUT'))); ?>

                                                <?php else: ?>
                                                <?php echo e(Form::open(['route' => 'good_issue.store'])); ?>

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
                                                
                                                    <label class="col-lg-2 col-form-label">Location</label>
                                                    <div class="col-lg-4">
                                                        <select class="form-control" name="location" required
                                                                id="supplier_id">
                                                        <option value="">Select Location</option>
                                                        <?php if(!empty($location)): ?>
                                                        <?php $__currentLoopData = $location; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                        <option <?php if(isset($data)): ?>
                                                            <?php echo e($data->location == $row->id  ? 'selected' : ''); ?>

                                                            <?php endif; ?> value="<?php echo e($row->id); ?>"><?php echo e($row->name); ?></option>

                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php endif; ?>

                                                    </select>
                                                    </div>
                                                </div>

                                                

                                                <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Type</label>
                                                   <div class="col-lg-4">
                                                    <select class="form-control type" name="type" required
                                                        id="type">
                                                <option value="">Select 
                                                <option <?php if(isset($data)): ?>
                                                    <?php echo e($data->type== 'Service'  ? 'selected' : ''); ?>

                                                    <?php endif; ?> value="Service">Service</option>
                                                    <option <?php if(isset($data)): ?>
                                                    <?php echo e($data->type== 'Maintenance'  ? 'selected' : ''); ?>

                                                    <?php endif; ?> value="Maintenance">Maintenance</option>
                                               

                                            </select>
                                                    </div>
                                                
                                                    <label
                                                    class="col-lg-2 col-form-label">Service/Maintainance</label>

                                                <div class="col-lg-4">
                                                    <select class="form-control type_id" name="type_id" required
                                                    id="type_id">

                                                    <?php if(!empty($data->type_id)): ?>
                                                   
                                                    <option value="">Select </option>
                                                    <?php if($data->type == 'Service'): ?>
                                                    <?php
                                                        $svc= App\Models\Service::all();
                                                        ?>
                                                          <?php $__currentLoopData = $svc; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                          <option <?php if(isset($data)): ?>
                                                              <?php echo e($data->type_id == $s->id  ? 'selected' : ''); ?>

                                                              <?php endif; ?> value="<?php echo e($s->id); ?>"><?php echo e($s->truck_name); ?> - <?php echo e($s->reg_no); ?></option> 
                                                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                       <?php elseif($data->type == 'Maintenance'): ?>
                                                       <?php
                                                        $mn= App\Models\Maintainance::all(); 
                                                        ?>
                                                          <?php $__currentLoopData = $mn; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                          <option <?php if(isset($data)): ?>
                                                              <?php echo e($data->type_id == $m->id  ? 'selected' : ''); ?>

                                                              <?php endif; ?> value="<?php echo e($m->id); ?>"><?php echo e($m->truck_name); ?>  - <?php echo e($m->reg_no); ?></option> 
                                                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                   <?php endif; ?>

                                                    <?php else: ?>
                                                   
                                                <option value="">Select </option>
                                                <?php endif; ?>
                                            </select>
                                                    </div>
                                                </div>
                                          
                                               

                                            <br>
                                            <h4 align="center">Enter  Details</h4>
                                            <hr>
                                            
                                            
                                            <button type="button" name="add" class="btn btn-success btn-xs add"><i
                                                    class="fas fa-plus"> Add item</i></button><br>
                                            <br>
                                            <div class="table-responsive">
                                            <table class="table table-bordered" id="cart">
                                                <thead>
                                                    <tr>
                                                        <th>Item Name</th>
                                                      
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>


                                                </tbody>
                                                <tfoot>
                                                    <?php if(!empty($id)): ?>
                                                    <?php if(!empty($items)): ?>
                                                    <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr class="line_items">
                                                        
                                                        <td><select name="item_id[]"
                                                            class="form-control item_name<?php echo e($i->order_no); ?>" required
                                                            >
                                                            <option value="">Select Item</option><?php $__currentLoopData = $inventory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <option value="<?php echo e($n->id); ?>"
                                                                <?php if(isset($i)): ?><?php if($n->id == $i->item_id): ?>
                                                                selected <?php endif; ?> <?php endif; ?> ><?php echo e($n->serial_no); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select></td>
                                                  <input type="hidden" name="quantity[]"
                                                            class="form-control item_quantity<?php echo e($i->order_no); ?>"
                                                            placeholder="quantity" id="quantity"
                                                            value="<?php echo e(isset($i) ? $i->quantity : ''); ?>"
                                                            required />       
                                       

                                                                <input type="hidden" name="saved_id[]"
                                                                class="form-control item_saved<?php echo e($i->order_no); ?>"
                                                                value="<?php echo e(isset($i) ? $i->id : ''); ?>"
                                                                required />
                                                        <td><button type="button" name="remove"
                                                                class="btn btn-danger btn-xs rem"
                                                                value="<?php echo e(isset($i) ? $i->id : ''); ?>"><i
                                                                    class="fas fa-trash"></i></button></td>
                                                    </tr>

                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php endif; ?>
                                                    <?php endif; ?>

                                                </tfoot>    
                                            </table>
                                        </div>


                                            <br>


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



    $(document).on('change', '.type', function() {
        var id = $(this).val();
        $.ajax({
            url: '<?php echo e(url("findIssueService")); ?>',
            type: "GET",
            data: {
                id: id
            },
            dataType: "json",
            success: function(response) {
                console.log(response);
                $("#type_id").empty();
                $("#type_id").append('<option value="">Select</option>');
                $.each(response,function(key, value)
                {
                    if(id == "Service"){
                        $("#type_id").append('<option value=' + value.id+ '>' + value.truck_name + ' - ' + value.reg_no + '</option>');
}
                   else if(id == "Maintenance"){
                    $("#type_id").append('<option value=' + value.id+ '>' + value.truck_name + '  - ' + value.reg_no + '</option>');
            }
                   
                });

                      
               
            }

        });

    });


});
</script>
    
    <script type="text/javascript">
    $(document).ready(function() {
    
    
        var count = 0;
    
    
        $('.add').on("click", function(e) {
    
            count++;
            var html = '';
            html += '<tr class="line_items">';   
                html +=
            '<td><select name="item_id[]" class="form-control item_name" required  data-sub_category_id="' +
            count +
            '"><option value="">Select Item</option><?php $__currentLoopData = $inventory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <option value="<?php echo e($n->id); ?>"><?php echo e($n->serial_no); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></td>';
        html +=
            '<input type="hidden" name="quantity[]" class="form-control item_quantity" data-category_id="' +
            count + '"placeholder ="quantity" id ="quantity" value= "1" required />';
           
            html +='<td><button type="button" name="remove" class="btn btn-danger btn-xs remove"><i class="fas fa-trash"></i></button></td>';
    
            $('tbody').append(html);
           
        });
    
        $(document).on('click', '.remove', function() {
            $(this).closest('tr').remove();
           
        });
    
    
        $(document).on('click', '.rem', function() {
            var btn_value = $(this).attr("value");
            $(this).closest('tr').remove();
            $('tbody').append(
                '<input type="hidden" name="removed_id[]"  class="form-control name_list" value="' +
                btn_value + '"/>');
           
        });
    
    });
    </script>
    
<script src="<?php echo e(url('assets/js/plugins/sweetalert/sweetalert.min.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/admin/web/del.co.tz/public_html/resources/views/inventory/good_issue.blade.php ENDPATH**/ ?>