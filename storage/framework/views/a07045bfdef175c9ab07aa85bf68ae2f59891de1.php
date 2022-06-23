 <table class="table table-striped" id="table-1">
                            <thead>
                                <tr role="row">

                                    <th class="" rowspan="1" colspan="1" style="width: 208.531px;">#</th>
                                    <th class="" rowspan="1" colspan="1" style="width: 186.484px;">Date</th>
                           <th class="" rowspan="1" colspan="1" style="width: 186.484px;">REF NO <br>Shipment Name</th>
                                    <th class="" rowspan="1" colspan="1" style="width: 186.484px;">Client <br>Receiver</th>
                               
                                    <th class="" rowspan="1" colspan="1" style="width: 141.219px;">Route
                                       
                                    </th>
                              <th class="" rowspan="1" colspan="1" style="width: 186.484px;">Truck</th>
                              <th class="" rowspan="1" colspan="1" style="width: 141.219px;">Driver</th>
                                    <th class="" rowspan="1" colspan="1" style="width: 141.219px;">Qty</th>
                                    

                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        colspan="1" style="width: 141.219px;">Status</th>

                                </tr>
                            </thead>
                            <tbody>
                                 <?php if(!@empty($report)): ?>
                                            <?php $__currentLoopData = $report; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr class="gradeA even" role="row">

                                                <td> <?php echo e($loop->iteration); ?></td>
                                                <td><?php echo e(Carbon\Carbon::parse($row->created_at)->format('d/m/Y')); ?></td>
                                                <td><?php echo e($row->pacel_number); ?> <br><?php echo e($row->pacel_name); ?></td>
                                                    <td>-<?php echo e($row->client->name); ?> <br>-<?php echo e($row->receiver_name); ?></td>                                              
                                                <td>From <?php echo e($row->region_s->name); ?> to <?php echo e($row->region_e->name); ?></td>
                                            <td><?php echo e($row->truck->reg_no); ?></td> 
                                             <td><?php echo e($row->driver->driver_name); ?></td>   
                                            <td><?php echo e($row->quantity); ?> </td>
                                                          
                                                
<td>
                                                    <?php if($row->status == 3): ?>
                                                     <div class="badge badge-dark badge-shadow">Collected</div>
                                                       <?php elseif($row->status == 4): ?>
                                                    <div class="badge badge-info badge-shadow">On Transit</div>
                                                       <?php elseif($row->status == 5): ?>
                                                    <div class="badge badge-primary badge-shadow">Off Loaded</div>
                                                      <?php elseif($row->status == 6): ?>
                                                    <div class="badge badge-success  badge-shadow">Delivered</div>
                                                    <?php endif; ?>
                                                </td>

                                              

                                            </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                      
                                            <?php endif; ?>
                            </tbody>
                        </table>

<script>
$(document).ready(function() {
    $('.dataTables-example').DataTable({
        pageLength: 25,
        responsive: true,
        searching: false,
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
<?php /**PATH /home/admin/web/del.co.tz/public_html/resources/views/order_movement/addreport.blade.php ENDPATH**/ ?>