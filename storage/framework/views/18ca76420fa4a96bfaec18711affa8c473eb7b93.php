<?php $__env->startSection('content'); ?>
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Cargo List </h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <?php if(empty($id)): ?>
                            <li class="nav-item">
                                <a class="nav-link <?php if(empty($id)): ?> active show <?php endif; ?>" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Cargo List</a>
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
                                                    <?php if($row->status == 2): ?>
                                                    <div class="badge badge-success badge-shadow">Order in Queue</div>

                                                    <?php endif; ?>
                                                </td>
                                          

                                                <td>
                                                    <?php if($row->status == 2  ): ?>                                              
                                                      <button type="button" class="btn btn-xs btn-primary"
                                            data-toggle="modal" data-target="#appFormModal"
                                            data-id="<?php echo e($row->id); ?>" data-type="collection"
                                            onclick="model(<?php echo e($row->id); ?>,'collection')">
                                            <i class="icon-eye-open"> </i>
                                            Mobilization
                                        </button>
                                                   

                                                    <?php endif; ?>
                                                </td>

                                            </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                            <?php endif; ?>

                                        </tbody>


                                    </table>
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

    </div>
</section>

<!-- discount Modal -->
<div class="modal inmodal show" id="appFormModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
    </div>
</div>
</div>
</div>

<div id="dialog" title="Confirmation Required">
  Are you sure about this?
</div>

<!-- continue Modal -->
<div class="modal inmodal show" id="newFormModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog-new">
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="formModal">Order Collection</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
      
        <div class="modal-footer bg-whitesmoke br">
            <button type="submit" class="btn btn-primary"  data-dismiss="modal">Yes</button>
            <a href="<?php echo e(route("order.collection")); ?>" class="btn btn-danger">No</a>
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





<script>
$(document).ready(function() {

  

    $(document).on('change', '.truck_id', function() {
        var id = $(this).val();
        $.ajax({
            url: '<?php echo e(url("findExp")); ?>',
            type: "GET",
            data: {
                id: id
            },
            dataType: "json",
            success: function(data) {
              console.log(data);


var a=data[0]["expire_date"];

const date1 = new Date();
const date2 = new Date(a);
const diffTime = (date2 - date1);
const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

                if (window.confirm('You are license is about to expire in '+diffDays+' days . Do you want to continue ? ')) {
  // Save it!
  console.log('Thing was saved to the database.');
} else {
  // Do nothing!
 var targetUrl = '<?php echo e(url("collection")); ?>';
 window.location.href = targetUrl;
  console.log('Thing was not saved to the database.');
}
    
      
    
               
            }

        });

    });



$(document).on('change', '.type', function() {
        var id = $(this).val();
     var collection=$('#collection').val();
        $.ajax({
            url: '<?php echo e(url("findTruck")); ?>',
            type: "GET",
            data: {
                id: id,
              collection: collection,
            },
            dataType: "json",
            success: function(response) {
                console.log(response);
                $("#test").empty();
               
                $.each(response,function(key, value)
                {
                 
                     $('#test').append(response.html);
                   
                });                      
               
            }

        });
  });


});
</script>



<script>
$(document).ready(function() {
$(document).on('change', '.truck_id', function() {
        var id = $(this).val();
        $.ajax({
            url: '<?php echo e(url("findDriver")); ?>',
            type: "GET",
            data: {
                id: id,
            },
            dataType: "json",
            success: function(response) {
                console.log(response);

                  $("#errors").empty();
              $("#save").attr("disabled", false);
                $("#driver").val('');
                 $("#driver_id").val('');

                          if (response == 'Please Assign Driver to the Truck.') {
                          $("#errors").append(response);
                         $("#save").attr("disabled", true);
                        } else {
                       $("#driver").val(response.driver_name);
                        $("#driver_id").val(response.id);
                        }

}

        });
  });


});
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/admin/web/del.co.tz/public_html/resources/views/order_movement/collection.blade.php ENDPATH**/ ?>