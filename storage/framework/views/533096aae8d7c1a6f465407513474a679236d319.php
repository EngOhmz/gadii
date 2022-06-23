<?php $__env->startSection('content'); ?>
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Loading List </h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <?php if(empty($id)): ?>
                            <li class="nav-item">
                                <a class="nav-link <?php if(empty($id)): ?> active show <?php endif; ?>" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Loading List</a>
                            </li>
                            <?php else: ?>
                           <li class="nav-item">
                                <a class="nav-link <?php if(!empty($id)): ?> active show <?php endif; ?>" id="profile-tab2"
                                    data-toggle="tab" href="#profile2" role="tab" aria-controls="profile"
                                    aria-selected="false"><?php echo e(__('ordering.create_quotation')); ?></a>
                            </li> 
                            <?php endif; ?>

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
                                                    style="width: 186.484px;">REF NO</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 186.484px;">Qty</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Route</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Client</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Amount</th>

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

                                                <td> <?php echo e($loop->iteration); ?></td>
                                                <td><?php echo e($row->pacel_number); ?></td>              
                                               <td><?php echo e($row->quantity); ?> </td>
                                                <td>From <?php echo e($row->route->from); ?> to <?php echo e($row->route->to); ?></td>
                                                <td><?php echo e($row->client->name); ?></td>           
                                                 <td><?php echo e(number_format($row->amount,2)); ?> <?php echo e($row->pacel->currency_code); ?></td>  
                                                    <!--<td><?php echo e($row->receiver_name); ?></td>-->


                                                <td>
                                                    <?php if($row->status == 3): ?>
                                                    <div class="badge badge-success badge-shadow">Collected</div>

                                                    <?php endif; ?>
                                                </td>
                                          

                                                <td>
                                               
                                                   <?php if($row->fuel  == 1): ?>
                                                      <button type="button" class="btn btn-xs btn-primary"
                                            data-toggle="modal" data-target="#appFormModal"
                                            data-id="<?php echo e($row->id); ?>" data-type="loading"
                                            onclick="model(<?php echo e($row->id); ?>,'loading')">
                                            <i class="icon-eye-open"> </i>
                                            Load
                                        </button>

                                 <?php else: ?>
                             
     <a  class="nav-link" title="Edit" data-toggle="modal"  href="" onclick="model(<?php echo e($row->id); ?>,'fuel')" value="<?php echo e($row->id); ?>" data-target="#appFormModal" >Assign Fuel and Mileage</a></li>
                        

                                                                 
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

<script type="text/javascript">
    function model(id, type) {

        let url = '<?php echo e(route("order_movement.show", ":id")); ?>';
        url = url.replace(':id', id)

        $.ajax({
            type: 'GET',
            url: url,
            data: {
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
    </script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/admin/web/del.co.tz/public_html/resources/views/order_movement/loading.blade.php ENDPATH**/ ?>