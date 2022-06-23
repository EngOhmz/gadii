<?php $__env->startSection('content'); ?>
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Invoice</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link <?php if(empty($id)): ?> active show <?php endif; ?>" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Invoice List</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php if(!empty($id)): ?> active show <?php endif; ?>" id="profile-tab2"
                                    data-toggle="tab" href="#profile2" role="tab" aria-controls="profile"
                                    aria-selected="false">New Invoice</a>
                            </li>

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
                                            <tr>

                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 186.484px;">Reference</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 186.484px;">Client Name</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 186.484px;">Invoice Date</th>
                                         <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 186.484px;">Due Date</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Due Amount</th>
                                                    
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
                                            <?php if(!@empty($purchases)): ?>
                                            <?php $__currentLoopData = $purchases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr class="gradeA even" role="row">

                                                <td>
                                                    <a class="nav-link" id="profile-tab2"
                                                            href="<?php echo e(route('cotton_sales.show',$row->id)); ?>" role="tab"
                                                            aria-selected="false"><?php echo e($row->reference); ?></a>
                                                </td>
                                                <td>
                                                      <?php echo e($row->supplier->name); ?>

                                                </td>
                                                
                                                <td><?php echo e($row->purchase_date); ?></td>
                                                     <td><?php echo e($row->due_date); ?></td>
                                                <td><?php echo e(number_format($row->due_amount,2)); ?> <?php echo e($row->exchange_code); ?></td>

                                               
                                               


                                                <td>
                                                    <?php if($row->status == 0): ?>
                                                    <div class="badge badge-danger badge-shadow">Not Approved</div>
                                                    <?php elseif($row->status == 1): ?>
                                                    <div class="badge badge-warning badge-shadow">Not Paid</div>
                                                    <?php elseif($row->status == 2): ?>
                                                    <div class="badge badge-info badge-shadow">Partially Paid</div>
                                                    <?php elseif($row->status == 3): ?>
                                                    <span class="badge badge-success badge-shadow">Fully Paid</span>
                                                    <?php elseif($row->status == 4): ?>
                                                    <span class="badge badge-danger badge-shadow">Cancelled</span>

                                                    <?php endif; ?>
                                                </td>
                                               
                                                
                                                <td>
                                                    <?php if($row->status != 0): ?>
                                               
                                                        <a class="nav-link" id="profile-tab2"
                                                                    href="<?php echo e(route('invoice.pay',$row->id)); ?>"
                                                                    role="tab"
                                                                    aria-selected="false">Make Payments</a>
                                                            </li>
                                                        
                                                        </ul>
                                                    </div>

                                                </td>
                                                <?php else: ?>
                                                <td></td>
                                                <?php endif; ?>
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
                                        <h5>Create Invoice</h5>
                                        <?php else: ?>
                                        <h5>Edit Invoice </h5>
                                        <?php endif; ?>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">
                                                <?php if(isset($id)): ?>
                                                <?php echo e(Form::model($id, array('route' => array('cotton_sales.update', $id), 'method' => 'PUT'))); ?>

                                              
                                                <?php else: ?>
                                                <?php echo e(Form::open(['route' => 'cotton_sales.store'])); ?>

                                                <?php echo method_field('POST'); ?>
                                                <?php endif; ?>


                                                <input type="hidden" name="type"
                                                class="form-control name_list"
                                                value="<?php echo e($type); ?>" />

                                                <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Reference</label>
                                                    <div class="col-lg-4">
                                                         <input type="text" name="reference"
                                                            placeholder=""
                                                            value="<?php echo e(isset($data) ? $data->reference : ''); ?>"
                                                            class="form-control" required>
                                                        
                                                    </div>
                                                    <label class="col-lg-2 col-form-label">Debtor Name</label>
                                                    <div class="col-lg-4">
                                                            <select class="" name="supplier_id" required
                                                                id="supplier_id">
                                                                <option value="">Select Debtor Name</option>
                                                                <?php if(!empty($supplier)): ?>
                                                                <?php $__currentLoopData = $supplier; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                                <option <?php if(isset($data)): ?>
                                                                    <?php echo e($data->supplier_id == $row->id  ? 'selected' : ''); ?>

                                                                    <?php endif; ?> value="<?php echo e($row->id); ?>"><?php echo e($row->account_name); ?></option>

                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                <?php endif; ?>

                                                            </select>
                                                           
                                                        
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Invoice Date</label>
                                                    <div class="col-lg-4">
                                                        <input type="date" name="purchase_date"
                                                            placeholder="0 if does not exist"
                                                            value="<?php echo e(isset($data) ? $data->purchase_date : date('Y-m-d')); ?>" <?php echo e(Auth::user()->can('edit-date') ? '' : 'readonly'); ?>

                                                            class="form-control">
                                                    </div>
                                                    <label class="col-lg-2 col-form-label">Due Date</label>
                                                    <div class="col-lg-4">
                                                        <input type="date" name="due_date"
                                                            placeholder="0 if does not exist"
                                                            value="<?php echo e(isset($data) ? $data->due_date : strftime(date('Y-m-d', strtotime("+30 days")))); ?>" <?php echo e(Auth::user()->can('edit-date') ? '' : 'readonly'); ?>

                                                            class="form-control">
                                                    </div>
                                                </div>


                                                <br>
                                                <h4 align="center">Enter Item Details</h4>
                                                <hr>
                                               <div class="form-group row">
                                                    <label class="col-lg-1 col-form-label">Currency</label>
                                                    <div class="col-lg-3">
                                                       <?php if(!empty($data->exchange_code)): ?>

                              <select class="" name="exchange_code" id="currency_code" required >
                            <option value="<?php echo e(old('currency_code')); ?>" disabled selected>Choose option</option>
                            <?php if(isset($currency)): ?>
                            <?php $__currentLoopData = $currency; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option  <?php if(isset($data)): ?> <?php echo e($data->exchange_code == $row->code ? 'selected' : 'USD'); ?> <?php endif; ?>  value="<?php echo e($row->code); ?>"><?php echo e($row->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </select>

                         <?php else: ?>
                       <select class="" name="exchange_code" id="currency_code" required >
                            <option value="<?php echo e(old('currency_code')); ?>" disabled >Choose option</option>
                            <?php if(isset($currency)): ?>
                            <?php $__currentLoopData = $currency; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                           <?php if($row->code == 'USD'): ?>
                            <option value="<?php echo e($row->code); ?>" selected><?php echo e($row->name); ?></option>
                           <?php else: ?>
                          <option value="<?php echo e($row->code); ?>" ><?php echo e($row->name); ?></option>
                           <?php endif; ?>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </select>


                     <?php endif; ?>
                                                    </div>
                                                    <label class="col-lg-1 col-form-label">Exchange Rate</label>
                                                    <div class="col-lg-3">
                                                        <input type="number" name="exchange_rate" step="0.01"
                                                            placeholder="1 if TZSH"
                                                            value="<?php echo e(isset($data) ? $data->exchange_rate : '2300.00'); ?>"
                                                            class="form-control" required>
                                                    </div>
                                    
                                              <label class="col-lg-1 col-form-label">Unit Price</label>
                                                    <div class="col-lg-3">
                                                        <input type="number" name="unit_price" step="0.01"
                                                            placeholder=""
                                                            value="<?php echo e(isset($data) ? $data->unit_price : ''); ?>"
                                                            class="form-control" required>
                                                    </div>
                                                </div>
                                                <hr>
                                                <button type="button" name="add" class="btn btn-success btn-xs add"><i
                                                        class="fas fa-plus"> Add item</i></button><br>
                                                <br>
                                                <div class="table-responsive">
                                                <table class="table table-bordered" id="cart">
                                                    <thead>
                                                        <tr>
                                                            <th>LOT NO </th>
                                                            <th>BALES</th>
                                                            <th>GROSS</th>
                                                            <th>TARE</th>
                                                            <th>NET</th>
                                                            
                                                            <th>ACTION</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>


                                                    </tbody>
                                                   
                                                      
                                                </table>
                                            </div>


                                                <br>
                                                <div class="form-group row">
                                                    <div class="col-lg-offset-2 col-lg-12">
                                                        <?php if(!@empty($id)): ?>

                                                        <a class="btn btn-sm btn-danger float-right m-t-n-xs"
                                                            href="<?php echo e(route('cotton_sales.index')); ?>">
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

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- supplier Modal -->
<div class="modal inmodal show" id="appFormModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formModal">Add Supplier</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
               <form id="addClientForm" method="post" action="javascript:void(0)">
            <?php echo csrf_field(); ?>
        <div class="modal-body">

            <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">

      <div class="form-group row"><label
                                                            class="col-lg-2 col-form-label">Name</label>

                                                        <div class="col-lg-10">
                                                            <input type="text" name="name"  id="name"                                                                
                                                                class="form-control" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row"><label
                                                            class="col-lg-2 col-form-label">Phone</label>

                                                        <div class="col-lg-10">
                                                            <input type="text" name="phone" id="phone"
                                                                class="form-control"  placeholder="+255713000000" required>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row"><label
                                                            class="col-lg-2 col-form-label">Email</label>
                                                        <div class="col-lg-10">
                                                            <input type="email" name="email" id="email"
                                                                class="form-control" required>
                                                        </div>
                                                    </div>

                                                <div class="form-group row"><label
                                                            class="col-lg-2 col-form-label">Address</label>

                                                        <div class="col-lg-10">
                                                            <textarea name="address" id="address" class="form-control" required>  </textarea>
                                                                                                                    

</div>
                                                    </div>

  <div class="form-group row"><label
                                                            class="col-lg-2 col-form-label">TIN</label>

                                                        <div class="col-lg-10">
                                                            <input type="text" name="TIN"  id="TIN"
                                                                value="<?php echo e(isset($data) ? $data->TIN : ''); ?>"
                                                                class="form-control" required>
                                                        </div>
                                                    </div>

                 
               
              </div>
</div>
                                                    </div>


        </div>
        <div class="modal-footer bg-whitesmoke br">
            <button type="submit" class="btn btn-primary" id="save" onclick="saveSupplier(this)" data-dismiss="modal">Save</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>


       </form>

            </div>
        </div>
    </div>
</div>
</div>
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
        var date = new Date( data[2] );
 
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
    new TomSelect("#supplier_id",{
        create: false,
        sortField: {
            field: "text",
            direction: "asc"
        }
    });
    new TomSelect("#currency_code",{
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
</script>
<script src="<?php echo e(url('assets/js/plugins/sweetalert/sweetalert.min.js')); ?>"></script>

<script>
$(document).ready(function() {

    $(document).on('click', '.remove', function() {
        $(this).closest('tr').remove();
    });

    $(document).on('change', '.item_name', function() {
        var id = $(this).val();
        var sub_category_id = $(this).data('sub_category_id');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '<?php echo e(url("findSalesPrice")); ?>',
            type: "GET",
            data: {
                id: id
            },
            dataType: "json",
            success: function(data) {
                console.log(data);
                $('.item_price' + sub_category_id).val(data[0]["gross_weight"]);
                $(".item_unit" + sub_category_id).val(data[0]["tale"]);
             $('.item_quantity' + sub_category_id).val(data[0]["bale_no"]);
                $(".item_tax" + sub_category_id).val(data[0]["net_weight"]);
               
            }

        });

    });


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
            '<td><select name="item_name[]" class="m-b form-control item_name" required  data-sub_category_id="' +
            count +
            '"><option value="">Select Item</option><?php $__currentLoopData = $name; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <option value="<?php echo e($n->id); ?>"><?php echo e($n->lot_no); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></td>';
        html +=
            '<td><input type="number" name="bales[]" class="form-control item_quantity' + count +
            '"  id ="quantity" value="" required readonly/></td>';
        html += '<td><input type="text" name="gross[]" class="form-control item_price' + count +
            '"  required  value="" readonly/></td>';
        html += '<td><input type="text" name="tare[]" class="form-control item_unit' + count +
            '"  value="" required  readonly/></td>';
        html += '<td><input type="text" name="net[]" id="net" class="form-control item_tax' + count +
            '"  value="" required  readonly/></td>';

        html +=
            '<td><button type="button" name="remove" class="btn btn-danger btn-xs remove"><i class="fas fa-trash"></i></button></td>';

        $('tbody').append(html);
        autoCalcSetup();

/*
             * Multiple drop down select
             */
            $(".m-b").select2({
                            });
          
 $('.m-b').select2({
                theme: 'bootstrap',
                            });

      
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



<script type="text/javascript">
function model(id, type) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: 'GET',
        url: '/courier/public/discountModal/',
        data: {
            'id': id,
            'type': type,
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

function saveSupplier(e) {
     
     var name = $('#name').val();
     var phone = $('#phone').val();
     var email = $('#email').val();
     var address = $('#address').val();
   var TIN= $('#TIN').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

     
          $.ajax({
            type: 'GET',
            url: '<?php echo e(url("addSupp")); ?>',
             data: {
                 'name':name,
                 'phone':phone,
                 'email':email,
                 'address':address,
                  'TIN':TIN,
             },
                dataType: "json",
             success: function(response) {
                console.log(response);

                               var id = response.id;
                             var name = response.name;

                             var option = "<option value='"+id+"'  selected>"+name+" </option>"; 

                             $('#supplier_id').append(option);
                              $('#appFormModal').hide();
                   
                               
               
            }
        });
}
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/admin/web/gaki.ema.co.tz/public_html/resources/views/cotton/manage_invoice_cotton.blade.php ENDPATH**/ ?>