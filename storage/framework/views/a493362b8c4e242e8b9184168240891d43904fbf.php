<?php $__env->startSection('content'); ?>
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4><?php echo e(__('ordering.quotation')); ?> </h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <?php if(empty($id)): ?>
                            <li class="nav-item">
                                <a class="nav-link <?php if(empty($id)): ?> active show <?php endif; ?>" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true"><?php echo e(__('ordering.quotation')); ?></a>
                            </li>
                            <?php else: ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-quotation-list')): ?>
                           <li class="nav-item">
                                <a class="nav-link <?php if(!empty($id)): ?> active show <?php endif; ?>" id="profile-tab2"
                                    data-toggle="tab" href="#profile2" role="tab" aria-controls="profile"
                                    aria-selected="false"><?php echo e(__('ordering.create_quotation')); ?></a>
                            </li> 
                            <?php endif; ?>
                            <?php endif; ?>

                        </ul>
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade <?php if(empty($id)): ?> active show <?php endif; ?>" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">
                                <div class="table-responsive">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-quotation-list')): ?>
                                    <table class="table table-striped" id="table-1">
                                        <thead>
                                            <tr>

                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 186.484px;"><?php echo e(__('ordering.ref_no')); ?></th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 186.484px;"><?php echo e(__('ordering.crop_type')); ?></th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 186.484px;"><?php echo e(__('ordering.quantity')); ?></th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;"><?php echo e(__('ordering.from')); ?></th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;"><?php echo e(__('ordering.to')); ?></th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;"><?php echo e(__('ordering.transporter')); ?></th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;"><?php echo e(__('ordering.estimated_cost')); ?></th>

                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;"><?php echo e(__('ordering.status')); ?></th>


    

                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if(!@empty($quotation)): ?>
                                            <?php $__currentLoopData = $quotation; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr class="gradeA even" role="row">

                                                <td>
                                                    <li> <a class="nav-link" id="profile-tab2"
                                                        href="<?php echo e(url('quotationDetails', $row->id)); ?>" role="tab"
                                                            aria-selected="false"><?php echo e($loop->iteration); ?></a></li>
                                                </td>
                                                <td><?php echo e($row->crop_types->crop_name); ?></td>
                                                <td><?php echo e($row->quantity); ?></td>

                                                <td><?php echo e($row->start_location); ?></td>

                                                <td><?php echo e($row->end_location); ?></td>

                                                <td><?php echo e($row->user->name); ?></td>

                                                <td><?php echo e($row->amount); ?>Tsh</td>

                                                <!--<td><?php echo e($row->receiver_name); ?></td>-->


                                                <td>
                                                    <?php if($row->status == 0): ?>
                                                    <div class="badge badge-danger badge-shadow">Not Paid</div>
                                                    <?php elseif($row->status == 1): ?>
                                                    <div class="badge badge-warning badge-shadow">Partially Paid</div>
                                                    <?php elseif($row->status == 2): ?>
                                                    <span class="badge badge-success badge-shadow">Quotation Created</span>


                                                    <?php endif; ?>
                                                </td>
                                          

                                                <td>
                                                
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit-quotation-list')): ?>
                                                    <div class="btn-group">
                                                        <button class="btn btn-xs btn-success dropdown-toggle"
                                                            data-toggle="dropdown">Change<span
                                                                class="caret"></span></button>
                                                        <ul class="dropdown-menu animated zoomIn">
                                                          
                                                          
                                                            <li class="nav-item"><a class="nav-link" title="quotation"
                                                                    
                                                                    href="<?php echo e(url('quotationDetails', $row->id)); ?>">
                                                                    <?php echo e(__('ordering.quotation_details')); ?></a></li>
                                                        </ul>
                                                    </div>
                                                    <?php endif; ?>

                                                </td>
                                            </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                            <?php endif; ?>

                                        </tbody>
                                    </table>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="tab-pane fade <?php if(!empty($id)): ?> active show <?php endif; ?>" id="profile2" role="tabpanel"
                                aria-labelledby="profile-tab2">

                                <div class="card">
                                    <div class="card-header">
                                        <?php if(empty($id)): ?>
                                        <h5><?php echo e(__('ordering.create_quotation')); ?></h5>
                                        <?php else: ?>
                                        <h5><?php echo e(__('ordering.create_quotation')); ?></h5>
                                        <?php endif; ?>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">
                                                <?php if(isset($id) && ($type=="edit")): ?>
                                                <?php echo e(Form::model($id, array('route' => array('orders.update', $id), 'method' => 'PUT'))); ?>

                                                <?php else: ?>
                                                <?php echo e(Form::open(['route' => 'orders.store'])); ?>

                                                <?php echo method_field('POST'); ?>
                                                <?php endif; ?>

                                         <input type="hidden" name="id" value="<?php echo e(isset($id) ? $id : ''); ?>">


                                               


                                                <br>
                                                <h4 align="center"><?php echo e(__('ordering.transport_cost')); ?></h4>
                                                <hr>
                                           
                                                <hr>
                                                <button type="button" name="add" class="btn btn-success btn-xs add"><i
                                                        class="fas fa-plus"><?php echo e(__('ordering.add_cost')); ?></i></button><br>
                                                <br>
                                                <table class="table table-bordered" id="cart">
                                                    <thead>
                                                        <tr>
                                                            <th><?php echo e(__('ordering.name')); ?></th>
                                                            <th><?php echo e(__('ordering.quantity')); ?></th>
                                                            <th><?php echo e(__('ordering.price')); ?></th>
                                                            <th><?php echo e(__('ordering.unit')); ?></th>
                                                            <th><?php echo e(__('ordering.tax')); ?></th>
                                                            <th><?php echo e(__('ordering.total')); ?></th>
                                                            <th><?php echo e(__('ordering.action')); ?></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>


                                                    </tbody>
                                                    <tfoot>
                                                        <?php if(!empty($id)): ?>
                                                        <?php if(!empty($items)): ?>
                                                        <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr class="line_items">
                                                            <td><select name="item_name[]"
                                                                    class="form-control item_name" required
                                                                    data-sub_category_id=<?php echo e($i->order_no); ?>>
                                                                    <option value="">Select Item</option><?php $__currentLoopData = $name; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <option value="<?php echo e($n->id); ?>"
                                                                        <?php if(isset($i)): ?><?php if($n->id == $i->item_name): ?>
                                                                        selected <?php endif; ?> <?php endif; ?> ><?php echo e($n->name); ?></option>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                </select></td>
                                                            <td><input type="text" name="quantity[]"
                                                                    class="form-control item_quantity<?php echo e($i->order_no); ?>"
                                                                    placeholder="quantity" id="quantity"
                                                                    value="<?php echo e(isset($i) ? $i->quantity : ''); ?>"
                                                                    required /></td>
                                                            <td><input type="text" name="price[]"
                                                                    class="form-control item_price<?php echo e($i->order_no); ?>"
                                                                    placeholder="price" required
                                                                    value="<?php echo e(isset($i) ? $i->price : ''); ?>" /></td>
                                                            <td><input type="text" name="unit[]"
                                                                    class="form-control item_unit<?php echo e($i->order_no); ?>"
                                                                    placeholder="unit" required
                                                                    value="<?php echo e(isset($i) ? $i->unit : ''); ?>" />
                                                            <td><select name="tax_rate[]"
                                                                    class="form-control item_tax'+count<?php echo e($i->order_no); ?>"
                                                                    required>
                                                                    <option value="0">Select Tax Rate</option>
                                                                    <option value="0" <?php if(isset($i)): ?><?php if('0'==$i->
                                                                        tax_rate): ?> selected <?php endif; ?> <?php endif; ?>>No tax</option>
                                                                    <option value="0.18" <?php if(isset($i)): ?><?php if('0.18'==$i->
                                                                        tax_rate): ?> selected <?php endif; ?> <?php endif; ?>>18%</option>
                                                                </select></td>
                                                            <input type="hidden" name="total_tax[]"
                                                                class="form-control item_total_tax<?php echo e($i->order_no); ?>'"
                                                                placeholder="total" required
                                                                value="<?php echo e(isset($i) ? $i->total_tax : ''); ?>" readonly
                                                                jAutoCalc="{quantity} * {price} * {tax_rate}" />
                                                            <input type="hidden" name="saved_items_id[]"
                                                                class="form-control item_saved<?php echo e($i->order_no); ?>"
                                                                value="<?php echo e(isset($i) ? $i->saved_items_id : ''); ?>"
                                                                required />
                                                            <td><input type="text" name="total_cost[]"
                                                                    class="form-control item_total<?php echo e($i->order_no); ?>"
                                                                    placeholder="total" required
                                                                    value="<?php echo e(isset($i) ? $i->total_cost : ''); ?>"
                                                                    readonly jAutoCalc="{quantity} * {price}" /></td>
                                                            <input type="hidden" name="items_id[]"
                                                                class="form-control name_list"
                                                                value="<?php echo e(isset($i) ? $i->items_id : ''); ?>" />
                                                            <td><button type="button" name="remove"
                                                                    class="btn btn-danger btn-xs rem"
                                                                    value="<?php echo e(isset($i) ? $i->items_id : ''); ?>"><i
                                                                        class="fas fa-trash"></i></button></td>
                                                        </tr>

                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php endif; ?>
                                                        <?php endif; ?>

                                                        <tr class="line_items">
                                                            <td colspan="4"></td>
                                                            <td><span class="bold"><?php echo e(__('ordering.sub_total')); ?> </span>: </td>
                                                            <td><input type="text" name="subtotal[]"
                                                                    class="form-control item_total"
                                                                    placeholder="subtotal" required
                                                                    jAutoCalc="SUM({total_cost})" readonly></td>
                                                        </tr>
                                                        <tr class="line_items">
                                                            <td colspan="4"></td>
                                                            <td><span class="bold"><?php echo e(__('ordering.tax')); ?> </span>: </td>
                                                            <td><input type="text" name="tax[]"
                                                                    class="form-control item_total" placeholder="tax"
                                                                    required jAutoCalc="SUM({total_tax})" readonly>
                                                            </td>
                                                        </tr>
                                                        <?php if(!@empty($data->discount > 0)): ?>
                                                        <tr class="line_items">
                                                            <td colspan="4"></td>
                                                            <td><span class="bold"><?php echo e(__('ordering.discount')); ?></span>: </td>
                                                            <td><input type="text" name="discount[]"
                                                                    class="form-control item_discount"
                                                                    placeholder="total" required
                                                                    value="<?php echo e(isset($data) ? $data->discount : ''); ?>"
                                                                    readonly></td>
                                                        </tr>
                                                        <?php endif; ?>

                                                        <tr class="line_items">
                                                            <td colspan="4"></td>
                                                            <?php if(!@empty($data->discount > 0)): ?>
                                                            <td><span class="bold">Total</span>: </td>
                                                            <td><input type="text" name="amount[]"
                                                                    class="form-control item_total" placeholder="total"
                                                                    required jAutoCalc="{subtotal} + {tax} - {discount}"
                                                                    readonly></td>
                                                            <?php else: ?>
                                                            <td><span class="bold"><?php echo e(__('ordering.total')); ?></span>: </td>
                                                            <td><input type="text" name="amount[]"
                                                                    class="form-control item_total" placeholder="total"
                                                                    required jAutoCalc="{subtotal} + {tax}" readonly>
                                                            </td>
                                                            <?php endif; ?>
                                                        </tr>
                                                    </tfoot>
                                                </table>



                                                <br>
                                                <div class="form-group row">
                                                    <div class="col-lg-offset-2 col-lg-12">
                                                        <?php if(!@empty($id) && ($type=="edit") ): ?>

                                                        <a class="btn btn-sm btn-danger float-right m-t-n-xs"
                                                            href="<?php echo e(route('purchase.index')); ?>">
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

<!-- discount Modal -->
<div class="modal inmodal show" id="appFormModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
    </div>
</div>
</div>
</div>


<!-- route Modal -->
<div class="modal inmodal show" id="routeModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formModal">Add Discount</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><strong>Make sure you enter valid information</strong> .</p>

                    <div class="form-group row"><label class="col-lg-2 col-form-label">from</label>

                        <div class="col-lg-10">
                            <input type="text" name="arrival_point" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row"><label class="col-lg-2 col-form-label">To</label>

                        <div class="col-lg-10">
                            <input type="text" name="destination_point" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group row"><label class="col-lg-2 col-form-label">Distance</label>

                        <div class="col-lg-10">
                            <input type="text" name="distance" class="form-control">
                        </div>
                    </div>

                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>


            </div>
        </div>
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
        $.ajax({
            url: '/agrihub/public/findPrice/',
            type: "GET",
            data: {
                id: id
            },
            dataType: "json",
            success: function(data) {
                console.log(data);
                $('.item_price' + sub_category_id).val(data[0]["price"]);
                $(".item_unit" + sub_category_id).val(data[0]["unit"]);
                $(".item_saved" + sub_category_id).val(data[0]["id"]);
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
            '<td><select name="item_name[]" class="form-control item_name" required  data-sub_category_id="' +
            count +
            '"><option value="">Select Item</option><?php $__currentLoopData = $costs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <option value="<?php echo e($n->id); ?>"><?php echo e($n->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></td>';
        html +=
            '<td><input type="text" name="quantity[]" class="form-control item_quantity" data-category_id="' +
            count + '"placeholder ="quantity" id ="quantity" required /></td>';
        html += '<td><input type="text" name="price[]" class="form-control item_price' + count +
            '" placeholder ="price" required  value=""/></td>';
        html += '<td><input type="text" name="unit[]" class="form-control item_unit' + count +
            '" placeholder ="unit" required /></td>';
        html += '<td><select name="tax_rate[]" class="form-control item_tax' + count +
            '" required ><option value="0">Select Tax Rate</option><option value="0">No tax</option><option value="0.18">18%</option></select></td>';
        html += '<input type="hidden" name="total_tax[]" class="form-control item_total_tax' + count +
            '" placeholder ="total" required readonly jAutoCalc="{quantity} * {price} * {tax_rate}"   />';
        html += '<input type="hidden" name="saved_items_id[]" class="form-control item_saved' + count +
            '"  required   />';
        html += '<td><input type="text" name="total_cost[]" class="form-control item_total' + count +
            '" placeholder ="total" required readonly jAutoCalc="{quantity} * {price}" /></td>';
        html +=
            '<td><button type="button" name="remove" class="btn btn-danger btn-xs remove"><i class="fas fa-trash"></i></button></td>';

        $('tbody').append(html);
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



<script type="text/javascript">
function model(id, type) {

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

function saveClient(e) {
    alert($('#address').val());

    var fname = $('#fname').val();
    var lname = $('#lname').val();
    var phone = $('#phone').val();
    var email = $('#email').val();
    var address = $('#address').val();
    var currency_code = $('currency_code').val();
    var tin = $('#tin').val;
    var vat = $('#vat').val;

    $.ajax({
        type: 'GET',
        url: '/courier/public/addClient/',
        data: {
            'fname': fname,
            'lname': lname,
            'phone': phone,
            'email': email,
            'address': address,
            'tin': tin,
            'vat': vat,
            'currency_code': currency_code,
        },
        cache: false,
        async: true,
        success: function(response) {
            var len = 0;
            if (response.data != null) {
                len = response.data.length;
            }

            if (len > 0) {
                $('#client').html("");
                for (var i = 0; i < len; i++) {
                    var id = response.data[i].id;
                    var name = response.data[i].fname;

                    var option = "<option value='" + id + "'>" + name + "</option>";

                    $("#client").append(option);
                    $('#appFormModal').hide();
                }
            }
        },
        error: function(error) {
            $('#appFormModal').modal('toggle');

        }
    });
}
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/admin/web/app.ema.co.tz/public_html/resources/views/orders/quotation_list.blade.php ENDPATH**/ ?>