<?php $__env->startSection('content'); ?>
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Stock Movement</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link <?php if(empty($id)): ?> active show <?php endif; ?>" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Stock Movement
                                    List</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php if(!empty($id)): ?> active show <?php endif; ?>" id="profile-tab2"
                                    data-toggle="tab" href="#profile2" role="tab" aria-controls="profile"
                                    aria-selected="false">New Stock Movement</a>
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
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Stock Reference</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Quantity</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Engine version: activate to sort column ascending"
                                                        style="width: 141.219px;">Source Center</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Destination Center</th>
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
                                            <?php if(!@empty($movement)): ?>
                                            <?php $__currentLoopData = $movement; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr class="gradeA even" role="row">
                                                <th><?php echo e($loop->iteration); ?></th>
                                                <td><?php echo e(Carbon\Carbon::parse($row->date)->format('M d, Y')); ?></td>
                                              
                                                 <td><?php echo e($row->item->reference); ?></td>
                                                <td><?php echo e($row->quantity); ?></td>
                                                <td>

                                                    <?php echo e($row->source->name); ?>

                                                  
                                                </td>
                                                    
                                                <td>
                                                   
                                                     <?php echo e($row->destination->name); ?>

                                                </td>

                                        
                                                   <td>
                                                    <?php if($row->status == 0): ?>
                                                    <div class="badge badge-info badge-shadow">Pending</div>
                                                    <?php elseif($row->status == 1): ?>
                                            <div class="badge badge-success badge-shadow">Approved</span>
                                                    <?php endif; ?>
                                                </td>
                                                      <td>
                                                   <?php if($row->status == 0): ?>
                                                    <a class="btn btn-xs btn-outline-info text-uppercase px-2 rounded"
                                                        href="<?php echo e(route("cotton_movement.edit", $row->id)); ?>">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                   
                                                    <?php echo Form::open(['route' => ['cotton_movement.destroy',$row->id],
                                                    'method' => 'delete']); ?>

                                                    <?php echo e(Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-xs btn-outline-danger text-uppercase px-2 rounded demo4', 'title' => 'Delete', 'onclick' => "return confirm('Are you sure?')"])); ?>

                                                    <?php echo e(Form::close()); ?>


 <div class="btn-group">
                                                        <button class="btn btn-xs btn-success dropdown-toggle" data-toggle="dropdown">Change<span class="caret"></span></button>
                                                        <ul class="dropdown-menu animated zoomIn">
                                                            <a  class="nav-link" title="Confirm Payment" onclick="return confirm('Are you sure? you want to confirm')"  href="<?php echo e(route('movement.approve', $row->id)); ?>">Confirm Movement</a></li>
                                                                          </ul></div>
                                                
                                                 
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
                                        <h5>Edit Stock Movement</h5>
                                        <?php else: ?>
                                        <h5>Add New Stock Movement</h5>
                                        <?php endif; ?>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">
                                                     <?php if(isset($id)): ?>
                                                <?php echo e(Form::model($id, array('route' => array('cotton_movement.update', $id), 'method' => 'PUT'))); ?>

                                                <?php else: ?>
                                                <?php echo e(Form::open(['route' => 'cotton_movement.store'])); ?>

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
                                                 
                                               </div>

                                             <div class="form-group row">
                                              <label class="col-lg-2 col-form-label">Source Center</label>
                                                    <div class="col-lg-4">
                                                     <select class="form-control source"  
                                                         id="source">
                                                 <option value="">Select 
                                                    <?php if(!empty($center)): ?>
                                                    <?php $__currentLoopData = $center; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                    <option <?php if(isset($data)): ?>
                                                        <?php echo e($data->source_location == $c->id  ? 'selected' : ''); ?>

                                                        <?php endif; ?> value="<?php echo e($c->id); ?>"><?php echo e($c->name); ?></option>

                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php endif; ?>                                              
 
                                             </select>
                                                   
                                                </div>
                                            </div>

                                              <?php if(!empty($data)): ?>
                                                <div class="form-group row">
                                              <label class="col-lg-2 col-form-label">Stock Reference</label>
                                                    <div class="col-lg-4">
                                                     <select class="form-control type" name="purchase_id" required
                                                         id="purchase_id">
                                                 <option value="">Select Stock Reference</option>
                                                    <?php if(!empty($purchases)): ?>
                                                    <?php $__currentLoopData = $purchases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                    <option <?php if(isset($data)): ?>
                                                        <?php echo e($data->purchase_id == $row->id  ? 'selected' : ''); ?>

                                                        <?php endif; ?> value="<?php echo e($row->purchase_id); ?>">Reference No <?php echo e($row->reference); ?>  with unit price of <?php echo e($row->price); ?> </option>

                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php endif; ?>                                              
 
                                             </select>
                                                   
                                                </div>
                                            </div>

                                          <?php else: ?>
                                            <div class="form-group row">
                                              <label class="col-lg-2 col-form-label">Stock Reference</label>
                                                    <div class="col-lg-4">
                                                     <select class="form-control type" name="purchase_id" required
                                                         id="purchase_id">
                                                             <option value="">Select Stock Reference</option>                               
 
                                             </select>
                                                   
                                                </div>
                                            </div>
                                         <?php endif; ?>

 
                                                
                                               
                                                

                                        <br>
 <div class=""> <p class="form-control-static" id="errors" style="text-align:center;color:red;"></p>   </div> 
                                                <h4 align="center">Enter Item Details</h4>
                                                <hr>
                                               
                                               <?php if(!empty($data)): ?>
                                               <div class="table-responsive">
                                                <table class="table table-bordered" id="cart">
                                                    <thead>
                                                        <tr>
                                                            <th>Name</th>
                                                            <th>Quantity</th>
                                                            <th>Price</th>                                                           
                                                            <th>Total</th>
                                                         
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                   
                                                        <?php $__currentLoopData = $item; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                   <tr class="line_items">
                                                            <td><br><textarea   class="form-control item_name"
                                                                     id="name" readonly>Cotton</textarea></td>
                                                            <td><br><input type="number" name="quantity[]"
                                                                    class="form-control item_quantity
                                                                    placeholder="quantity" id="quantity"
                                                                    value="<?php echo e(isset($i) ? $i->quantity : ''); ?>"
                                                                    required /></td>
                                                            <td><br><input type="text" name="price[]"
                                                                    class="form-control item_price"
                                                                    placeholder="" required
                                                                   value="<?php echo e(isset($i) ? $i->price : ''); ?>"" /></td>
                                                            <td><br><input type="text" name="total_cost[]"
                                                                    class="form-control item_total"
                                                                    placeholder="total" required
                                                                    value="<?php echo e(isset($i) ? $i->total_cost : ''); ?>"
                                                                    readonly jAutoCalc="{quantity} * {price}" /></td>
                                                           <input type="hidden" name="name="history_id[]""
                                                                    class="form-control item_history"
                                                                    value="">
                                                                  <input type="hidden" name="cotton_item_id[]""
                                                                    class="form-control"
                                                                    value="<?php echo e(isset($i) ? $i->id : ''); ?>">
                                                           <input type="hidden" name="item_id[]""
                                                                   class="btn btn-xs item_id"
                                                                     value="<?php echo e(isset($i) ? $i->item_id : ''); ?>"  
                                                               
                                                        >
                                                        </tr>

                                                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </tbody>
                                                    <tfoot>
                                                   <tr class="line_items">
                                                            <td colspan="2"></td>
                                                           
                                                            <td><span class="bold">Total Cost</span>: </td>
                                                            <td><input type="text" name="amount[]"
                                                                    class="form-control item_total" placeholder="total"
                                                                    required jAutoCalc="SUM({total_cost})" readonly>
                                                            </td>
                                                         
                                                        </tr>
                                                    </tfoot>
                                                </table>
</div>

                                                <?php else: ?>
                                                
                                                                              <div class="table-responsive">
                                                <table class="table table-bordered" id="cart">
                                                    <thead>
                                                        <tr>
                                                            <th>Name</th>
                                                            <th>Quantity</th>
                                                            <th>Price</th>                                                           
                                                            <th>Total</th>
                                                            
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                   
                                                     
                                                   <tr class="line_items">
                                                            <td><br><textarea   class="form-control item_name"
                                                                     id="name" readonly></textarea></td>
                                                            <td><br><input type="number" name="quantity[]"
                                                                    class="form-control item_quantity
                                                                    placeholder="quantity" id="quantity"
                                                                    value=" value=""
                                                                    required /></td>
                                                            <td><br><input type="text" name="price[]"
                                                                    class="form-control item_price"
                                                                    placeholder="" required
                                                                    value="" /></td>
                                                            <td><br><input type="text" name="total_cost[]"
                                                                    class="form-control item_total"
                                                                    placeholder="total" required
                                                                    value=""
                                                                    readonly jAutoCalc="{quantity} * {price}" /></td>
                                                           <input type="hidden" name="name="history_id[]""
                                                                    class="form-control item_history"
                                                                    value="">
                                                               
                                                         <input type="hidden" name="item_id[]""
                                                                   class="btn btn-xs item_id"
                                                                    value="" >
                                                        </tr>

                                                      
                                                    </tbody>
                                                    <tfoot>
                                                   <tr class="line_items">
                                                            <td colspan="2"></td>
                                                           
                                                            <td><span class="bold">Total Cost</span>: </td>
                                                            <td><input type="text" name="amount[]"
                                                                    class="form-control item_total" placeholder="total"
                                                                    required jAutoCalc="SUM({total_cost})" readonly>
                                                            </td>
                                                         
                                                        </tr>
                                                    </tfoot>
                                                </table>
</div>
<?php endif; ?>
 <br>
                                                <h4 align="center">Enter Levy Details</h4>
                                                <hr>
<button type="button" name="add" class="btn btn-success btn-xs add"><i
                                                        class="fas fa-plus"> Add Levy</i></button><br>
                                                <br>

                                                   <?php if(!empty($data)): ?>
                                               <div class="table-responsive">
                                           <table class="table table-bordered" id="cart">
                                                 <thead>
                                                        <tr>
                                                            <th>Name</th>                                                          
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="levy">
                                                   
                                                        <?php $__currentLoopData = $levy_item; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $l): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                   <tr class="line_items">
                                                             <td><select name="levy_id[]" class="form-control item_name" required  data-sub_category_id=<?php echo e($l->order_no); ?>>
                                                             <option value="">Select Item</option>
                                                         <?php $__currentLoopData = $levy; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                                                        <option value="<?php echo e($n->id); ?>" <?php if(isset($l)): ?><?php if($n->id == $l->levy_id): ?>  selected <?php endif; ?> <?php endif; ?>><?php echo e($n->account_name); ?></option>   
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select></td>
                                                           
                                                         
                                                            <td><button type="button" name="remove"
                                                                    class="btn btn-danger btn-xs rem"
                                                                    value="<?php echo e(isset($l) ? $l->id : ''); ?>"><i
                                                                        class="fas fa-trash"></i></button></td>
                                                                     </td>
  <input type="hidden" name="levy_item_id[]""
                                                                    class="form-control item_history"
                                                                    value="<?php echo e(isset($l) ? $l->id : ''); ?>">
                                                        </tr>

                                                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </tbody>
                                                    <tfoot>
                                                  
                                                    </tfoot>
                                                </table>
</div>

                                                <?php else: ?>
                                                
                                                                              <div class="table-responsive">
                                                <table class="table table-bordered" id="cart">
                                                    <thead>
                                                        <tr>
                                                            <th>Name</th>                                                          
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="levy">


                                                    </tbody>
                                                    <tfoot>
                                                      
                                                </table>
                                            </div>
<?php endif; ?>
                                              


<br><br>  
<div class="form-group row">
                                              <label class="col-lg-2 col-form-label">Transport Cost</label>
                                                    <div class="col-lg-4">
                                                  
                                              <input type="text" name="transport"   value="<?php echo e(isset($data) ? $data->transport : ''); ?>"
                                                            class="form-control" required>
                                                   
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


    $(document).on('change', '.type', function() {
        var id = $(this).val();
        $.ajax({
            url: '<?php echo e(url("findQuantity")); ?>',
            type: "GET",
            data: {
                id: id,
            },
            dataType: "json",
            success: function(data) {
              console.log(data);
              $(".item_price").val(data.price);
                $(".item_quantity").val(data.due_quantity);
               $(".item_history").val(data.id);
                   $(".item_id").val(data.items_id);
               $(".item_name").val('Cotton');
            }

        });

    });






});
</script>


<script type="text/javascript">
$(document).ready(function() {



    function autoCalcSetup() {
        $('table#cart').jAutoCalc('destroy');
        $('table#cart tr.line_items').jAutoCalc({
            keyEventsFire: true,
            decimalPlaces: 2,
            emptyAsZero: true
        });
        $('table#cart').jAutoCalc({
            decimalPlaces: 2
        });
    }
    autoCalcSetup();

   

});
</script>



<script type="text/javascript">
$(document).ready(function() {


    var count = 0;


    function autoCalcSetup() {
        $('table#cart').jAutoCalc('destroy');
        $('table#cart tr.line_items').jAutoCalc({
            keyEventsFire: true,
            decimalPlaces: 2,
            emptyAsZero: true
        });
        $('table#cart').jAutoCalc({
            decimalPlaces: 2
        });
    }
    autoCalcSetup();

    $('.add').on("click", function(e) {

        count++;
        var html = '';
        html += '<tr class="line_items">';
        html +=
            '<td><select name="levy_id[]" class="form-control item_name" required  data-sub_category_id="' +
            count +
            '"><option value="">Select Item</option><?php $__currentLoopData = $levy; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <option value="<?php echo e($n->id); ?>"><?php echo e($n->account_name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></td>';      
       
        html +=
            '<td><button type="button" name="remove" class="btn btn-danger btn-xs remove"><i class="fas fa-trash"></i></button></td>';

        $('#levy').append(html);
        autoCalcSetup();
    });

    $(document).on('click', '.remove', function() {
        $(this).closest('tr').remove();
        autoCalcSetup();
    });


    $(document).on('click', '.rem', function() {
        var btn_value = $(this).attr("value");
        $(this).closest('tr').remove();
        $('tfoot').append(
            '<input type="hidden" name="removed_id[]"  class="form-control name_list" value="' +
            btn_value + '"/>');
        autoCalcSetup();
    });

});
</script>

<script>
$(document).ready(function() {

    $(document).on('change', '.source', function() {
        var id = $(this).val();
        $.ajax({
            url: '<?php echo e(url("findPurchase")); ?>',
            type: "GET",
            data: {
                id: id
            },
            dataType: "json",
            success: function(response) {
                console.log(response);
                $("#purchase_id").empty();
                $("#purchase_id").append('<option value="">Select Stock Reference</option>');
                $.each(response,function(key, value)
                {
                 
                    $("#purchase_id").append('<option value=' + value.purchase_id+ '>Reference No ' + value.reference + ' with unit price of ' + value.price + '</option>');
                   
                });                      
               
            }

        });

    });





});
</script>

<script src="<?php echo e(url('assets/js/plugins/sweetalert/sweetalert.min.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/admin/web/app.ema.co.tz/public_html/resources/views/cotton/good_movement.blade.php ENDPATH**/ ?>