<?php $__env->startSection('content'); ?>
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Fuel and Mileage </h4>
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
                                    aria-selected="false">Create Fuel and Mileage</a>
                            </li> 
                            <?php endif; ?>

                        </ul>
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade <?php if(!empty($id)): ?> active show <?php endif; ?>" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">
                                  <?php echo e(Form::model($id, array('route' => array('order_movement.update', $id), 'method' => 'PUT'))); ?>

 
        <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Truck</label>
                                                    <div class="col-lg-4">
                                                        <select class="form-control" name="truck_id" required
                                                        id="supplier_id">
                                                        <option value="">Select</option>
                                                        <?php if(!empty($truck)): ?>
                                                        <?php $__currentLoopData = $truck; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                        <option <?php if(isset($data)): ?>
                                                            <?php echo e($data->truck_id == $row->id  ? 'selected' : ''); ?>

                                                            <?php endif; ?> value="<?php echo e($row->id); ?>"><?php echo e($row->reg_no); ?></option>

                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php endif; ?>

                                                    </select>
                                                    </div>
                                                    <label class="col-lg-2 col-form-label">Driver</label>
                                                    <div class="col-lg-4">
                                                       
                                                            <select class="form-control" name="driver_id" required
                                                                id="driver">
                                                                <option value="">Select</option>
                                                                <?php if(!empty($driver)): ?>
                                                                <?php $__currentLoopData = $driver; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                                <option <?php if(isset($data)): ?>
                                                                    <?php echo e($data->route_id == $row->id  ? 'selected' : ''); ?>

                                                                    <?php endif; ?> value="<?php echo e($row->id); ?>"> <?php echo e($row->driver_name); ?> </option>

                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                <?php endif; ?>

                                                            </select>
                                                          
                                                    </div>
                                                </div>

                                           <div class="form-group row">
                                                 
                                                    <label class="col-lg-2 col-form-label">Route</label>
                                                    <div class="col-lg-4">
                                                        <div class="input-group">
                                                            <select class="form-control" name="route_id" required
                                                                id="route">
                                                                <option value="">Select</option>
                                                                <?php if(!empty($route)): ?>
                                                                <?php $__currentLoopData = $route; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                                <option <?php if(isset($data)): ?>
                                                                    <?php echo e($data->route_id == $row->id  ? 'selected' : ''); ?>

                                                                    <?php endif; ?> value="<?php echo e($row->id); ?>">From <?php echo e($row->from); ?> to  <?php echo e($row->to); ?></option>

                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                <?php endif; ?>

                                                            </select>
                                                            <div class="input-group-append">
                                                                <button class="btn btn-primary" type="button"
                                                                    data-toggle="modal" href="routeModal"  
                                                                    data-target="#routeModal"><i
                                                                        class="fa fa-plus-circle"></i></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Fuel Rate per Distance</label>
                                                    <div class="col-lg-4">
                                                      <input type="number" step="0.001"  name="fuel" value="" required class="form-control">
                                                    </div>
                                                    <label class="col-lg-2 col-form-label">Mileage Rate per Distance</label>
                                                    <div class="col-lg-4">
                                                        <input type="number" step="0.001" name="mileage" value="" required class="form-control">
                                                    </div>
                                                </div>

                  <input type="hidden" name="type" value="driver" required class="form-control">

                                 <div class="form-group row">
                                                    <div class="col-lg-offset-2 col-lg-12">
                                                      
                                                        <button class="btn btn-sm btn-primary float-right m-t-n-xs"
                                                            type="submit">Save</button>
                                                       
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

<!-- route Modal -->
<div class="modal inmodal show" id="routeModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formModal">Add Route</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
  <form id="addRouteForm" method="post" action="javascript:void(0)">
            <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <p><strong>Make sure you enter valid information</strong> .</p>

                    
                  
                 <div class="form-row">
                                  <div class="form-group col-md-6">
                                    <label for="inputState">Departure Region</label>
                                    <select  id="from_region_id" name="from_region_id" id="from_region_id"  class="form-control from_region">
                                      <option ="">Select Departure Region</option>
                                      <?php if(!empty($region)): ?>
                                                        <?php $__currentLoopData = $region; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                        <option <?php if(isset($data)): ?>
                                                            <?php echo e($data->to_region_id == $row->id  ? 'selected' : ''); ?>

                                                            <?php endif; ?> value="<?php echo e($row->id); ?>"><?php echo e($row->name); ?></option>

                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php endif; ?>
                                    </select>
                                  </div>

                  
              <div class="form-group col-md-6">
                                    <label for="inputState">Departure District</label>
                                      <select id="from_district_id" name="from_district_id"  class="form-control from_district">
                                      <option selected="">Select Departure District</option>
                                    
                                    </select>
                           </div>
                             </div>



                                                                         <div class="form-row">
                                  <div class="form-group col-md-6">
                                    <label for="inputState">Arrival Region</label>
                                    <select  id="to_region_id" name="to_region_id"  class="form-control to_region">
                                      <option ="">Select Arrival Region</option>
                                      <?php if(!empty($region)): ?>
                                                        <?php $__currentLoopData = $region; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                        <option <?php if(isset($data)): ?>
                                                            <?php echo e($data->from_region_id == $row->id  ? 'selected' : ''); ?>

                                                            <?php endif; ?> value="<?php echo e($row->id); ?>"><?php echo e($row->name); ?></option>

                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php endif; ?>
                                    </select>
                                  </div>

                   
              <div class="form-group col-md-6">
                                    <label for="inputState">Arrival District</label>
                                    <select id="to_district_id" name="to_district_id" class="form-control to_district">
                                      <option selected="">Select Arrival District</option>
                                    
                                    </select>
                                  </div>

                             </div>


                                                    <div class="form-group row"><label
                                                            class="col-lg-2 col-form-label">Distance (KM)</label>

                                                        <div class="col-lg-10">
                                                            <input type="number" name="distance"  step="0.001"
                                                                value=""
                                                                class="form-control" required>
                                                        </div>
                                                    </div>


                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="submit" class="btn btn-primary route" onclick="saveRoute(this)">Save</button>
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

    function saveRoute(e){
     
      var distance = $('#distance').val();
     var to_region_id = $('#to_region_id').val();    
     var from_region_id = $('#from_region_id').val();
     var to_district_id = $('#to_district_id').val();    
     var from_district_id= $('#from_district_id').val();
     
          $.ajax({
            type: 'GET',
            url: '<?php echo e(url("addRoute")); ?>',
             data: {
                 'to_region_id': to_region_id,
                 'distance':distance,
                 'from_region_id' : from_region_id,
                 'from_district_id' : from_district_id,
               'to_district_id': to_district_id,
             },
          dataType: "json",
             success: function(response) {
                console.log(response);

                               var id = response.id;
                             var arrival_point = response.from;
                              var destination_point = response.to;

                             var option = "<option value='"+id+"'  selected>From "+arrival_point+" to "+destination_point+"</option>"; 

                             $('#route').append(option);
                              $('#routeModal').hide();
                              $('.modal-backdrop').remove();
                   
                               
               
            }
          
        });
}



    function model(id,type) {

$.ajax({
    type: 'GET',
    url: '<?php echo e(url("discountModal")); ?>',
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



function calculateCost() {
    
    $('#price,#litres').on('input',function() {
    var price= parseInt($('#price').val());
    var qty = parseFloat($('#litres').val());
    console.log(qty);
    $('#total_c').val((10* 2 ? 10* 2 : 0).toFixed(2));
    });
    
    }
</script>

<script>
$(document).ready(function() {

    $(document).on('change', '.from_region', function() {
        var id = $(this).val();
        $.ajax({
            url: '<?php echo e(url("findFromRegion")); ?>',
            type: "GET",
            data: {
                id: id
            },
            dataType: "json",
            success: function(response) {
                console.log(response);
                $("#from_district_id").empty();
                $("#from_district_id").append('<option value="">Select Departure District</option>');
                $.each(response,function(key, value)
                {
                 
                    $("#from_district_id").append('<option value=' + value.id+ '>' + value.name + '</option>');
                   
                });                      
               
            }

        });

    });

});
</script>


<script>
$(document).ready(function() {

    $(document).on('change', '.to_region', function() {
        var id = $(this).val();
        $.ajax({
            url: '<?php echo e(url("findToRegion")); ?>',
            type: "GET",
            data: {
                id: id
            },
            dataType: "json",
            success: function(response) {
                console.log(response);
                $("#to_district_id").empty();
                $("#to_district_id").append('<option value="">Select Arrival District</option>');
                $.each(response,function(key, value)
                {
                 
                    $("#to_district_id").append('<option value=' + value.id+ '>' + value.name + '</option>');
                   
                });                      
               
            }

        });

    });

});
</script>
  


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/admin/web/del.co.tz/public_html/resources/views/order_movement/fuel.blade.php ENDPATH**/ ?>