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
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit-cotton-movement')): ?>
                            <li class="nav-item">
                                <a class="nav-link <?php if(!empty($id)): ?> active show <?php endif; ?>" id="profile-tab2"
                                    data-toggle="tab" href="#profile2" role="tab" aria-controls="profile"
                                    aria-selected="false">New Stock Movement</a>
                            </li>
                            
                                   <li class="nav-item">
                                <a class="nav-link <?php if(!empty($id)): ?> active show <?php endif; ?>" id="profile-tab3"
                                    data-toggle="tab" href="#profile3" role="tab" aria-controls="profile"
                                    aria-selected="false">Purchase</a>
                            </li>
                            <?php endif; ?>

                        </ul>
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade <?php if(empty($id)): ?> active show <?php endif; ?>" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">
                                <div class="table-responsive">
                        <table border="0" cellspacing="15" cellpadding="20">
        <tbody>

<tr>
                 <td></td><td></td><td></td>
        <td><b>Date Filter</b></td><td></td><td><b>Minimum date:</b></td>
            <td><input type="text" id="min" name="min"   class="form-control "></td>
       
            <td><b>Maximum date:</b></td>
            <td><input type="text" id="max" name="max"   class="form-control "></td>
        </tr>
    </tbody></table>

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
                             <td><a  class="nav-link" title="Edit" data-toggle="modal" class="discount"  href="" onclick="model(<?php echo e($row->id); ?>,'quantity')" value="<?php echo e($row->id); ?>" data-target="#itemsFormModal" ><?php echo e($row->quantity); ?></a></td>
                                                
                                                <?php if($row->status2 != 2): ?>
                                                <td>  <?php echo e($row->source->name); ?>  </td>
                                                <?php else: ?>
                                                <td>  <?php echo e(App\Models\AccountCodes::find($row->source_location)->account_name); ?>  </td>
                                                <?php endif; ?>
                                                
                                                <td>  <?php echo e($row->destination->name); ?>  </td>
                                                   <td>
                                                    <?php if($row->status == 0): ?>
                                                    <div class="badge badge-info badge-shadow">Pending</div>
                                                    <?php elseif($row->status == 1): ?>
                                            <div class="badge badge-success badge-shadow">Approved</span>
                                                    <?php endif; ?>
                                                </td>
                                                      <td>
                                                   <?php if($row->status == 0): ?>
                                                            <a  class="nav-link" title="Confirm Payment" onclick="return confirm('Are you sure? you want to confirm')"  href="<?php echo e(route('movement.approve', $row->id)); ?>">Confirm Movement</a></li>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                            <?php endif; ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                                <div class="tab-pane fade" id="profile3" role="tabpanel"
                                aria-labelledby="profile-tab3">

                                <div class="card">
                                    <div class="card-header">
                                        <?php if(empty($id)): ?>
                                        <h5>Create Stock Control</h5>
                                        <?php else: ?>
                                        <h5>Edit Stock Control </h5>
                                        <?php endif; ?>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">
                                                <?php if(isset($id)): ?>
                                                <?php echo e(Form::model($id, array('route' => array('purchase_cotton.update', $id), 'method' => 'PUT'))); ?>

                                              
                                                <?php else: ?>
                                                <?php echo e(Form::open(['route' => 'purchase_cotton.store'])); ?>

                                                <?php echo method_field('POST'); ?>
                                                <?php endif; ?>


                                                <input type="hidden" name="type"
                                                class="form-control name_list"
                                                value="creditor" />

                                              
                                                       <div class="form-group row">
                                                    


                     <?php if(!empty($data)): ?>
                      <label
                                                        class="col-lg-2 col-form-label">Collection Center</label>
                                                    <div class="col-lg-4">
                                                       <select class="center " name="location" id="account_id"  required>
                                                    <option value="">Select Collection Center</option> 
                                                        <?php $__currentLoopData = $center; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>                                                             
                                                            <option value="<?php echo e($c->id); ?>" <?php if(isset($data)): ?><?php if($data->location == $c->id): ?> selected <?php endif; ?> <?php endif; ?> ><?php echo e($c->name); ?></option>
                                                               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                              </select>
                                                    </div>
                 <?php else: ?>
                                 <label
                                                        class="col-lg-2 col-form-label">Creditor Name</label>
                                                    <div class="col-lg-4">
                                                       <select class=" center" name="location" id="account_id"  required>
                                                    <option value="">Select Collection Center</option> 
                                                    <?php if(!empty($all_center)): ?>
                                                    <?php $__currentLoopData = $all_center; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>                                                             
                                                    <option value="<?php echo e($c->id); ?>" <?php if(isset($data)): ?><?php if($data->location == $c->id): ?> selected <?php endif; ?> <?php endif; ?> ><?php echo e($c->account_name); ?></option>
                                                       <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                      
                                                              </select>
                                                    </div>
  <?php endif; ?>
  <?php endif; ?>
         </div>                                      <br>

                                                <div class="form-group row">

                                                    
                                                        <label class="col-lg-2 col-form-label">Purchase Date</label>
                                                    <div class="col-lg-4">
                                                        <input type="date" name="date"
                                                            placeholder="0 if does not exist"
                                                            value="<?php echo e(isset($data) ? $data->date : date("Y-m-d")); ?>" <?php echo e(Auth::user()->can('edit-date') ? '' : 'readonly'); ?>

                                                            class="form-control">
                                                    </div>
                                                    
                                                    <label class="col-lg-2 col-form-label">Reference</label>
                                                    <div class="col-lg-4">
                                                       <input type="text" name="reference"
                                                            placeholder=""
                                                            value="<?php echo e(isset($data) ? $data->weight : ''); ?>"
                                                            class="form-control" required>
                                                    </div> 
                                                    
                                                </div>
                                              <div class="form-group row">
                                                  <!--  <label class="col-lg-2 col-form-label">Due Date</label> -->
                                                    <div class="col-lg-4">
                                                        <input type="hidden" name="due_date"
                                                            placeholder="0 if does not exist"
                                                            value="<?php echo e(isset($data) ? $data->due_date : date("Y-m-d")); ?>"  readonly
                                                            class="form-control">
                                                    </div>                                                   
                                                </div>

                                                <br>
 <div class=""> <p class="form-control-static" id="errors" style="text-align:center;color:red;"></p>   </div> 
                                                <h4 align="center">Enter Item Details</h4>
                                                <hr>
                                               
                                               
                                                
                                                <br>
                                                <div class="table-responsive">
                                                <table class="table table-bordered" id="cart">
                                                    <thead>
                                                        <tr>
                                                            <th>Name</th>
                                                            <th>Quantity</th>
                                                            <th>Price</th>
                                                            <th>Unit</th>
                                                           <th>Tax Rate</th>
                                                            
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                           <tr class="line_items">

            <td><select name="item_id" class="form-control item_name" required ><option value="">Select Item</option><?php $__currentLoopData = $name; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($n->id); ?>"><?php echo e($n->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> </select></td>      
            <td><input type="number" name="quantity" class="form-control item_quantity" placeholder ="quantity" id ="quantity" required /></td>
        <td><input type="text" name="price" class="form-control item_price" placeholder ="price" required  value=""/></td>
      <td><input type="text" name="unit" class="form-control item_unit" placeholder ="unit" required /></td>
       <td><select name="tax_rate" class="form-control item_tax" required ><option value="0">Select Tax Rate</option><option value="0">No tax</option><option value="0.18">18%</option></select></td>
            
</tr>
                                                    </tbody>
                                                   
                                                       
                                                        
                                                </table>
                                            </div>


                                                <br>
                                                <div class="form-group row">
                                                    <div class="col-lg-offset-2 col-lg-12">
                                                        <?php if(!@empty($id)): ?>

                                                        <a class="btn btn-sm btn-danger float-right m-t-n-xs"
                                                            href="<?php echo e(route('purchase_cotton.index')); ?>">
                                                            cancel
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
                                                        <input type="text" name="date" id="date" 
                                                           
                                                            value="<?php echo e(isset($data) ? $data->date : date("y-m-d")); ?>" <?php echo e(Auth::user()->can('edit-date') ? '' : 'readonly'); ?>

                                                            class="form-control" required>
                                                    </div>
                                              <label class="col-lg-2 col-form-label">Source Center</label>
                                                    <div class="col-lg-4">
                                                     <select class="source select_center" style="width: 100%"  
                                                         id="source" name="source">
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

                                                 <div class="form-group row">

                                            </div>

                                            
                                             
                                             
                                                

                                        <br>
 <div id="data"> 
                                                
                                          </div>
<!--end of data table-->

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
<section>
    
                    <div class="modal inmodal show " id="appFormModal" tabindex="-1" role="dialog" aria-hidden="true">
                          <div class="modal-dialog">
    </div>
</div  
</section>

 <!-- discount Modal -->
  <div class="modal inmodal show " id="itemsFormModal" tabindex="-1" role="dialog" aria-hidden="true">
                          <div class="modal-dialog">
    </div>
</div></div>
  </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
var minDate, maxDate;
 
// Custom filtering function which will search data in column four between two values
$.fn.dataTable.ext.search.push(
    function( settings, data, dataIndex ) {
        var min = minDate.val();
        var max = maxDate.val();
        var date = new Date( data[1] );
 
        if (
            ( min === null && max === null ) ||
            ( min === null && date <= max ) ||
            ( min <= date   && max === null ) ||
            ( min <= date   && date <= max )
        ) {
            return true;
        }
        return false;
    }
);



</script>

<script>
$(document).ready(function() {
       new TomSelect("#account_id",{
        create: false,
        sortField: {
            field: "text",
            direction: "asc"
        }
    });
    
    new TomSelect(".select_center",{
        create: false,
        sortField: {
            field: "text",
            direction: "asc"
        }
    });
   // Create date inputs
    minDate = new DateTime($('#min'), {
        format: 'YYYY-MM-DD'
    });
    maxDate = new DateTime($('#max'), {
         format: 'YYYY-MM-DD'
    });

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

  var table = $('#table-1').DataTable();
 
    // Refilter the table
    $('#min, #max').on('change', function () {
        table.draw();
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
    function model(id,type) {

        $.ajax({
            type: 'GET',
            url: '<?php echo e(url("itemsModal")); ?>',
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
                $('#itemsFormModal').modal('toggle');

            }
        });

    }
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
       var total = $('#qty').val();
        $.ajax({
            url: '<?php echo e(url("findPurchase")); ?>',
            type: "GET",
            data: {
                id: id,
            total: total,
            },
            dataType: "json",
            success: function(response) {
                console.log(response);
                $("#data").empty();
                $.each(response,function(key, value)
                {
                 
                    $('#data').html(response.html);
                  
                });                      
               
            }

        });

    });





});
</script>

<script src="<?php echo e(url('assets/js/plugins/sweetalert/sweetalert.min.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/admin/web/gaki.ema.co.tz/public_html/resources/views/cotton/good_movement.blade.php ENDPATH**/ ?>