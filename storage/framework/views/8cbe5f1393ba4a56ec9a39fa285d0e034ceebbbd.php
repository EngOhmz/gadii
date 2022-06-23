<?php $__env->startSection('content'); ?>
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Service</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link <?php if(empty($id)): ?> active show <?php endif; ?>" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Service
                                    List</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php if(!empty($id)): ?> active show <?php endif; ?>" id="profile-tab2"
                                    data-toggle="tab" href="#profile2" role="tab" aria-controls="profile"
                                    aria-selected="false">New Service</a>
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
                                                    style="width: 141.219px;">Truck</th>
                                                 
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Km Reading</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Mechanical</th>
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
                                            <?php if(!@empty($service)): ?>
                                            <?php $__currentLoopData = $service; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr class="gradeA even" role="row">
                                                <th><?php echo e($loop->iteration); ?></th>
                                                <td><?php echo e(Carbon\Carbon::parse($row->date)->format('M d, Y')); ?></td>
                                                <td>
                                                    <?php    
                                                    $tr=App\Models\Truck::where('id', $row->truck)->get();   
                                                  ?>
                                                     <?php $__currentLoopData = $tr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                     <a href="#view<?php echo e($row->truck); ?>" data-toggle="modal"><?php echo e($t->reg_no); ?> -<?php echo e($t->truck_name); ?></a>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </td>
                                             
                                                    
                                                <td><a href="#minor<?php echo e($row->id); ?>" data-toggle="modal"><?php echo e($row->reading); ?></a></td>
                                                <td>
                                                    <?php    
                                                    //$st=App\Models\User::where('id', $row->mechanical)->get(); 
                                            $st=App\Models\FieldStaff::where('id', $row->mechanical)->get();   
                                                  ?>
                                                     <?php $__currentLoopData = $st; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php echo e($s->name); ?>

                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </td>

                                                      <td>
                                                    <?php if($row->status == 0): ?>
                                                    <div class="badge badge-danger badge-shadow">Incomplete</div>
                                                    <?php elseif($row->status == 1): ?>
                                                    <div class="badge badge-success badge-shadow">Complete</div>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if($row->status == 0): ?>
                                                    <a class="btn btn-xs btn-outline-primary text-uppercase px-2 rounded"
                                                    href="<?php echo e(route("service.approve", $row->id)); ?>" onclick="return confirm('Are you sure?')" title="Change Status">
                                                    <i class="fa fa-check"></i>
                                                </a>
                                              
                                                    <a class="btn btn-xs btn-outline-info text-uppercase px-2 rounded"
                                                        href="<?php echo e(route("service.edit", $row->id)); ?>">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                   
                                                    <?php echo Form::open(['route' => ['service.destroy',$row->id],
                                                    'method' => 'delete']); ?>

                                                    <?php echo e(Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-xs btn-outline-danger text-uppercase px-2 rounded demo4', 'title' => 'Delete', 'onclick' => "return confirm('Are you sure?')"])); ?>

                                                    <?php echo e(Form::close()); ?>


                               <?php else: ?>
    <?php if($row->report == 0): ?>
                         <a class="nav-link" title="Assign"
                                                    data-toggle="modal" href=""  value="<?php echo e($row->id); ?>" data-type="assign" data-target="#appFormModal"
                                                    onclick="model(<?php echo e($row->id); ?>,'service')">Create Mechanical Report </a>  
    <?php elseif($row->report == 1): ?>
                         <a class="nav-link" title="View"
                                                    data-toggle="modal" href=""  value="<?php echo e($row->id); ?>" data-type="view" data-target="#appFormModal"
                                                    onclick="model(<?php echo e($row->id); ?>,'mechanical_service')">View Mechanical Report </a>  
  <?php endif; ?>
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
                                        <h5>Edit Service</h5>
                                        <?php else: ?>
                                        <h5>Add New Service</h5>
                                        <?php endif; ?>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">
                                                     <?php if(isset($id)): ?>
                                                <?php echo e(Form::model($id, array('route' => array('service.update', $id), 'method' => 'PUT'))); ?>

                                                <?php else: ?>
                                                <?php echo e(Form::open(['route' => 'service.store'])); ?>

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
                                                
                                                    <label class="col-lg-2 col-form-label">Truck</label>
                                                    <div class="col-lg-4">
                                                        <select class="form-control" name="truck" required
                                                                id="supplier_id">
                                                        <option value="">Select Truck Name</option>
                                                        <?php if(!empty($truck)): ?>
                                                        <?php $__currentLoopData = $truck; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                        <option <?php if(isset($data)): ?>
                                                            <?php echo e($data->truck == $row->id  ? 'selected' : ''); ?>

                                                            <?php endif; ?> value="<?php echo e($row->id); ?>"><?php echo e($row->reg_no); ?> - <?php echo e($row->truck_name); ?></option>

                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php endif; ?>

                                                    </select>
                                                    </div>
                                                </div>

                                                

                                                <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Km Reading</label>
                                                   <div class="col-lg-4">
                                                    <input type="text" name="reading"
                                                            placeholder=""
                                                            value="<?php echo e(isset($data) ? $data->reading : ''); ?>"
                                                            class="form-control" required>
                                                    </div>
                                                
                                               
                                             
                                                    <label
                                                        class="col-lg-2 col-form-label">Mechanical</label>

                                                    <div class="col-lg-4">
                                                        <select class="form-control" name="mechanical" required
                                                        id="supplier_id">
                                                <option value="">Select Mechanical</option>
                                                <?php if(!empty($staff)): ?>
                                                <?php $__currentLoopData = $staff; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                <option <?php if(isset($data)): ?>
                                                    <?php echo e($data->mechanical == $row->id  ? 'selected' : ''); ?>

                                                    <?php endif; ?> value="<?php echo e($row->id); ?>"><?php echo e($row->name); ?></option>

                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php endif; ?>

                                            </select>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label
                                                    class="col-lg-2 col-form-label">Service History</label>

                                                <div class="col-lg-4">
                                                    <textarea name="history" 
                                            class="form-control" required><?php if(isset($data)): ?><?php echo e($data->history); ?> <?php endif; ?></textarea>
                                                </div>
                                                <label
                                                class="col-lg-2 col-form-label">Next Major Service</label>

                                            <div class="col-lg-4">
                                                <textarea name="major" 
                                        class="form-control" required><?php if(isset($data)): ?><?php echo e($data->major); ?> <?php endif; ?></textarea>
                                            </div>
                                            </div>

                                            <br>
                                            <h4 align="center">Enter Minor Service Details</h4>
                                            <hr>
                                            
                                            
                                            <button type="button" name="add" class="btn btn-success btn-xs add"><i
                                                    class="fas fa-plus"> Add item</i></button><br>
                                            <br>
                                            <div class="table-responsive">
                                            <table class="table table-bordered" id="cart">
                                                <thead>
                                                    <tr>
                                                        <th>Next Minor Service</th>
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
                                                        
                                                       
                                        <td>
                                            <textarea name="minor[]" 
                                        class="form-control item_price<?php echo e($i->order_no); ?>" required style="margin-top:10px;"><?php if(isset($i)): ?><?php echo e($i->minor); ?> <?php endif; ?></textarea>
                                         
                                            </td>

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

                                              <br>
                                            <h4 align="center">Enter Inventory</h4>
                                            <hr>
                                            
                                            
                                            <button type="button" name="add" class="btn btn-success btn-xs addCF"><i
                                                    class="fas fa-plus"> Add item</i></button><br>
                                            <br>
                                            <div class="table-responsive">
                                              <table class="table table-bordered" id="inventory">
                                                <thead>
                                                    <tr>
                                                        <th>Inventory Item</th>
                                                         <th>Quantity</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>


                                                </tbody>
                                                <tfoot>
                                                    <?php if(!empty($id)): ?>
                                                    <?php if(!empty($inv)): ?>
                                                    <?php $__currentLoopData = $inv; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $in): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr class="line_items">
                                                        
                                                       
                                        <td>
                              <select name="item_name[]" class="form-control item_name" required><option value="">Select Item</option><?php $__currentLoopData = $i_name; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <option  <?php if(isset($in)): ?>
                                                    <?php echo e($in->item_name== $n->id  ? 'selected' : ''); ?>

                                                    <?php endif; ?> value="<?php echo e($n->id); ?>"><?php echo e($n->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select>        
                                            </td>
                                      <td><input type="number" name="quantity[]"   class="form-control item_qty<?php echo e($in->order_no); ?>"   value="<?php echo e(isset($in) ? $in->quantity : ''); ?>"  required /></td>
                                                              
                                                               
                                                        <td><button type="button" name="remove"
                                                                class="btn btn-danger btn-xs rem_inv"
                                                                value="<?php echo e(isset($in) ? $in->id : ''); ?>"><i
                                                                    class="fas fa-trash"></i></button></td>

                                                <input type="hidden" name="saved_inv_id[]"
                                                                class="form-control item_saved<?php echo e($i->order_no); ?>"
                                                                value="<?php echo e(isset($in) ? $in->id : ''); ?>"
                                                                required />
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

<?php if(!empty($service)): ?>
<?php $__currentLoopData = $service; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<!-- Modal -->
<div class="modal inmodal " id="view<?php echo e($row->truck); ?>"  tabindex="-1" role="dialog" aria-hidden="true">
                     <div class="modal-dialog modal-lg"><div class="modal-dialog modal-lg" role="document">
<div class="modal-content">
   <div class="modal-header">
       <h5 class="modal-title"  style="text-align:center;"> 
        <?php    
        $tr=App\Models\Truck::where('id', $row->truck)->get();   
      ?>
         <?php $__currentLoopData = $tr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
         Service History For <?php echo e($t->truck_name); ?>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <h5>
       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
           <span aria-hidden="true">×</span>
       </button>
   </div>


   <div class="modal-body">
<div class="table-responsive">
                       <table class="table table-bordered table-striped">
<thead>
               <tr>
                <th>#</th>
                  <th>Date</th>
                       <th>Driver</th>
                       <th>Km Reading</th>
                   <th>Service History</th>
                   <th>Status</th>
               </tr>
               </thead>

               <?php
                        

                        $history = \App\Models\Service::where('truck', $row->truck)->get();                                               
?>

<tbody>   
    <?php $__currentLoopData = $history; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $h): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <tr>
                                <th><?php echo e($loop->iteration); ?></th>
                                <td><?php echo e(Carbon\Carbon::parse($h->date)->format('M d, Y')); ?></td>
                              
                                <td>
                                    <?php    
                                    $driver=App\Models\Driver::where('id', $h->driver)->get();   
                                  ?>
                                     <?php $__currentLoopData = $driver; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php echo e($d->driver_name); ?>

                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </td>
                                <td ><?php echo e($h->reading); ?></td>
                                <td ><?php echo e($h->history); ?></td>
                                <td>
                                    <?php if($h->status == 0): ?>
                                    <div class="badge badge-danger badge-shadow">Incomplete</div>
                                    <?php elseif($h->status == 1): ?>
                                    <div class="badge badge-success badge-shadow">Complete</div>
                                    <?php endif; ?>
                                </td>
                   
               </tr> 
               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                   </tbody>
                       </table>
                      </div>

   </div>
  
</div>
</div></div>
</div>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>

<?php if(!empty($service)): ?>
<?php $__currentLoopData = $service; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<!-- Modal -->
<div class="modal inmodal " id="minor<?php echo e($row->id); ?>"  tabindex="-1" role="dialog" aria-hidden="true">
                     <div class="modal-dialog modal-lg"><div class="modal-dialog modal-lg" role="document">
<div class="modal-content">
   <div class="modal-header">
       <h5 class="modal-title"  style="text-align:center;"> 
        <?php    
        $tr=App\Models\Truck::where('id', $row->truck)->get();   
      ?>
         <?php $__currentLoopData = $tr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
         Service History For <?php echo e($t->truck_name); ?>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
       </h5>

        
       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
           <span aria-hidden="true">×</span>
       </button>
   </div>

   
   <div class="modal-body">

<div class="table-responsive">
    <table class="table table-bordered table-striped">
               <tr>                
                   <th> Next Major Service</th>
                   <td ><?php echo e($row->major); ?></td>
               </tr>
                       </table>


                       <table class="table table-bordered table-striped">
<thead>

    
               <tr>
                <th>#</th>                 
                   <th>Next Minor Service</th>
               </tr>
               </thead>

               <?php
                        

                        $minor = \App\Models\ServiceItem::where('service_id', $row->id)->get();                                               
?>

<tbody>   
    
    <?php $__currentLoopData = $minor; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <tr>
                                <th><?php echo e($loop->iteration); ?></th>
                                <td ><?php echo e($m->minor); ?></td>
                               
                   
               </tr> 
               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                   </tbody>
                       </table>
                      </div>

   </div>
  
</div>
</div></div>
</div>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>
<!-- discount Modal -->
<div class="modal inmodal show" id="appFormModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
    </div>
</div>
</div>
</div>
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


    
    <script type="text/javascript">
    $(document).ready(function() {
    
    
        var count = 0;
    
    
        $('.add').on("click", function(e) {
    
            count++;
            var html = '';
            html += '<tr class="line_items">';   
                  
            html += '<td><textarea name="minor[]" class="form-control item_price' + count +'" required  value="" style="margin-top:10px;"/></textarea></td>';
           
            html +='<td><button type="button" name="remove" class="btn btn-danger btn-xs remove"><i class="fas fa-trash"></i></button></td>';
    
            $("#cart > tbody ").append(html);
           
        });
    
        $(document).on('click', '.remove', function() {
            $(this).closest('tr').remove();
           
        });
    
    
        $(document).on('click', '.rem', function() {
            var btn_value = $(this).attr("value");
            $(this).closest('tr').remove();
           $("#cart > tbody ").append(
                '<input type="hidden" name="removed_id[]"  class="form-control name_list" value="' +
                btn_value + '"/>');
           
        });
    
    });
    </script>


<script type="text/javascript">
$(document).ready(function() {


    var count = 0;

    $(document).on('click', '.addCF', function() {

        count++;
        var html = '';
        html += '<tr class="line_items">';
        html +='<td><select name="item_name[]" class="form-control item_name" required  data-sub_category_id="' +count +'"><option value="">Select Item</option><?php $__currentLoopData = $i_name; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i_n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <option value="<?php echo e($i_n->id); ?>"><?php echo e($i_n->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></td>';
          html +='<td><input type="number" name="quantity[]"   class="form-control item_qty"   value=""  required /></td>';
        html +=
            '<td><button type="button" name="remove" class="btn btn-danger btn-xs remove_inv"><i class="fas fa-trash"></i></button></td>';
console.log(html);
        $("#inventory > tbody ").append(html);
    
    });

    $(document).on('click', '.remove_inv', function() {
        $(this).closest('tr').remove();
       
    });


      $(document).on('click', '.rem_inv', function() {
            var btn_value = $(this).attr("value");
            $(this).closest('tr').remove();
            $("#inventory > tbody ").append(
                '<input type="hidden" name="removed_inv_id[]"  class="form-control name_list" value="' +
                btn_value + '"/>');
           
        });

});
</script>

<script type="text/javascript">
$(document).ready(function() {


    var count = 0;

    $(document).on('click', '.addService', function() {

        count++;
        var html = '';
        html += '<tr class="line_items">';
        html +=
            '<td><select name="item_name[]" class="form-control item_name" required  data-sub_category_id="' +
            count +
            '"><option value="">Select </option><?php $__currentLoopData = $name; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <option value="<?php echo e($n->id); ?>"><?php echo e($n->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></td>';
        html +=
            '<td><button type="button" name="remove" class="btn btn-danger btn-xs remove_inv"><i class="fas fa-trash"></i></button></td>';
console.log(html);
        $("#service > tbody ").append(html);
    
    });

    $(document).on('click', '.remove_inv', function() {
        $(this).closest('tr').remove();
       
    });


  
});
</script>

<script type="text/javascript">
$(document).ready(function() {


    var count = 0;

    $(document).on('click', '.addRecommedation', function() {

        count++;
        var html = '';
        html += '<tr class="line_items">';
        html +='<td><br><textarea name="recommedation[]" class="form-control item_name" required  data-sub_category_id="' + count + '"></textarea></td>';
        html +='<td><button type="button" name="remove" class="btn btn-danger btn-xs remove_re"><i class="fas fa-trash"></i></button></td>';
console.log(html);
        $("#recommedation > tbody ").append(html);
    
    });

    $(document).on('click', '.remove_re', function() {
        $(this).closest('tr').remove();
       
    });


  
});
</script>
    
<script type="text/javascript">
    function model(id,type) {

$.ajax({
    type: 'GET',
     url: '<?php echo e(url("invModal")); ?>',
    data: {
        'id': id,
        'type':type,
    },
    cache: false,
    async: true,
    success: function(data) {
        //alert(data);
        $('.modal-dialog').html(data);
    },
    error: function(error) {
        $('#appFormModal').modal('toggle');

    }
});

}

    </script>
<script src="<?php echo e(url('assets/js/plugins/sweetalert/sweetalert.min.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/admin/web/del.co.tz/public_html/resources/views/inventory/service.blade.php ENDPATH**/ ?>