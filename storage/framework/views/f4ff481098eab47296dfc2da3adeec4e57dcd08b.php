<?php $__env->startSection('content'); ?>
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Collection Center</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link <?php if(empty($id)): ?> active show <?php endif; ?>" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Collection Center List</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php if(!empty($id)): ?> active show <?php endif; ?>" id="profile-tab2"
                                    data-toggle="tab" href="#profile2" role="tab" aria-controls="profile"
                                    aria-selected="false">New Collection Center</a>
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
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Name</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Manager</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                       rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Operator</th> 
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Location</th>
                                         
                                     <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Quantity</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if(!@empty($warehouse)): ?>
                                            <?php $__currentLoopData = $warehouse; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr class="gradeA even" role="row">
                                                <th><?php echo e($loop->iteration); ?></th>
                                                <td><?php echo e($row->name); ?></td>
                                                <td><?php echo e($row->manager); ?></td>
                                              <td> <?php echo e($row->operator->name); ?></td>
                                           <td><?php echo e($row->ward->name); ?>, <?php echo e($row->district->name); ?>,<?php echo e($row->region->name); ?></td>                                                                
                        <td> <a  class="nav-link" title="Edit" data-toggle="modal" class="discount"  href="" onclick="model(<?php echo e($row->id); ?>,'quantity')" value="<?php echo e($row->id); ?>" data-target="#appFormModal" ><?php echo e($row->quantity); ?></a> </td>
                                                <td>

                                                    <a class="btn btn-xs btn-outline-info text-uppercase px-2 rounded"
                                                        href="<?php echo e(route("collection_center.edit", $row->id)); ?>">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <a class="btn btn-xs btn-outline-danger text-uppercase px-2 rounded demo4"
                                                        href="<?php echo e(route("collection_center.destroy", $row->id)); ?>">
                                                        <i class="fa fa-trash"></i>
                                                    </a>


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
                                            <h5>Edit Collection Center</h5>
                                            <?php else: ?>
                                            <h5>Add New Collection Center</h5>
                                            <?php endif; ?>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">
                                            <?php if(isset($id)): ?>
                                                    <?php echo e(Form::model($id, array('route' => array('collection_center.update', $id), 'method' => 'PUT'))); ?>

                                                    <?php else: ?>
                                                    <?php echo e(Form::open(['route' => 'collection_center.store'])); ?>

                                                    <?php echo method_field('POST'); ?>
                                                    <?php endif; ?>

                                                    <div class="form-group row"><label
                                                            class="col-lg-2 col-form-label">Name <span class="required" style="color:red;"> * </span></label>

                                                        <div class="col-lg-4">
                                                            <input type="text" name="name"
                                                                value="<?php echo e(isset($data) ? $data->name : ''); ?>"
                                                                class="form-control" required>
                                                        </div>

                                                           <label class="col-lg-2 col-form-label">Operator <span class="required" style="color:red;"> * </span></label>
<?php $a=1; ?>
                                                        <div class="col-lg-4">
                                                <div class="input-group-append">
                                                              <select name="operator_id" id="operator" class="form-control" required>
                                                                         <option value="">Select</option>
                                                          <?php if(!empty($operator)): ?>
                                                          <?php $__currentLoopData = $operator; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                          <option <?php if(isset($data)): ?>
                                                          <?php echo e($data->operator_id == $row->id  ? 'selected' : ''); ?>

                                                          <?php endif; ?> value="<?php echo e($row->id); ?>"><?php echo e($row->name); ?></option>
                                                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                          <?php endif; ?>

                                                        </select>
                                                                       </select>
                                                  <div class="input-group-append">
                                                  <button class="btn btn-primary" type="button" data-toggle="modal" onclick="model(<?php echo e($a); ?>,'operator')" value="<?php echo e($a); ?>" data-target="#appFormModal"><i class="fa fa-plus-circle"></i></button>
                                                  </div>
                                                 </div>                            

</div>
                                                    </div>
                                                    <div class="form-group row"><label
                                                            class="col-lg-2 col-form-label">Manager Full Name<span class="required" style="color:red;"> * </span></label>

                                                        <div class="col-lg-4">
                                                            <input type="text" name="manager"
                                                                value="<?php echo e(isset($data) ? $data->manager : ''); ?>"
                                                                class="form-control"  placeholder="" required>
                                                        </div>
                                                    <label
                                                            class="col-lg-2 col-form-label">Manager Phone Number <span class="required" style="color:red;"> * </span></label>

                                                        <div class="col-lg-4">
                                                            <input type="text" name="manager_contact"
                                                                value="<?php echo e(isset($data) ? $data->manager_contact : ''); ?>"
                                                                class="form-control" placeholder="+255713200100" required>
                                                        </div>
                                                    </div>

                                                <div class="form-group row"><label
                                                            class="col-lg-2 col-form-label">Insurance </label>

                                                        <div class="col-lg-4">
                                                                <div class="input-group">
                                                              <select id="licence"  name="insurance_id" class="form-control">
                                                                         <option value="">Select</option>
                                                          <?php if(!empty($insurance)): ?>
                                                          <?php $__currentLoopData = $insurance; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                          <option <?php if(isset($data)): ?>
                                                          <?php echo e($data->insurance_id == $row->id  ? 'selected' : ''); ?>

                                                          <?php endif; ?> value="<?php echo e($row->id); ?>"><?php echo e($row->insurance_name); ?></option>
                                                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                          <?php endif; ?>

                                                        </select>
                                                         </select>
                                                  <div class="input-group-append">
                                                  <button class="btn btn-primary" type="button" data-toggle="modal" onclick="model(<?php echo e($a); ?>,'licence')" value="<?php echo e($a); ?>" data-target="#appFormModal"><i class="fa fa-plus-circle"></i></button>
                                                  </div>
                                                 </div>
                                                 </div>                                            

                                                    

                         

                                             
                                                    </div>

 <div class="form-group row"><label
                                                            class="col-lg-2 col-form-label">Is it  Main Center<span class="required" style="color:red;"> * </span></label>

                                                        <div class="col-lg-4">
                                                           <select  id="" name="head" class="form-control" required>
                                      <option ="">Select option</option>
                                                        <option <?php if(isset($data)): ?>
                                                            <?php echo e($data->head == '1'  ? 'selected' : ''); ?>

                                                            <?php endif; ?> value="1">Yes</option>
                                                         <option <?php if(isset($data)): ?>
                                                            <?php echo e($data->head == '0'  ? 'selected' : ''); ?>

                                                            <?php endif; ?> value="0">No</option>
                                                       
                                    </select>
                                                        </div>
                                                    
                                                    </div>

<br>
                                          <div class="form-group row">
                                  <div class="form-group col-md-4">
                                    <label for="inputState">Region <span class="required" style="color:red;"> * </span></label>
                                    <select  id="selectRegionid" name="region_id" class="form-control region" required>
                                      <option ="">Select region</option>
                                      <?php if(!empty($region)): ?>
                                                        <?php $__currentLoopData = $region; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                        <option <?php if(isset($data)): ?>
                                                            <?php echo e($data->region_id == $row->id  ? 'selected' : ''); ?>

                                                            <?php endif; ?> value="<?php echo e($row->id); ?>"><?php echo e($row->name); ?></option>

                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php endif; ?>
                                    </select>
                                  </div>

                     <?php if(!empty($data)): ?>
                      <div class="form-group col-md-4">
                                    <label for="inputState">District <span class="required" style="color:red;"> * </span></label>
                                    <select id="selectDistrictid" name="district_id" class="form-control district" required>
                                      <option>Select district</option>
                                    <?php if(!empty($district)): ?>
                                                        <?php $__currentLoopData = $district; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                        <option <?php if(isset($data)): ?>
                                                            <?php echo e($data->district_id == $row->id  ? 'selected' : ''); ?>

                                                            <?php endif; ?> value="<?php echo e($row->id); ?>"><?php echo e($row->name); ?></option>

                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php endif; ?>
                                    </select>
                                  </div>
                 <?php else: ?>
              <div class="form-group col-md-4">
                                    <label for="inputState">District</label>
                                    <select id="selectDistrictid" name="district_id" class="form-control district"  required>
                                      <option selected="">Select district</option>
                                    
                                    </select>
                                  </div>
  <?php endif; ?>
                            
            
 <?php if(!empty($data)): ?>
                      <div class="form-group col-md-4">
                                    <label for="inputState">Ward <span class="required" style="color:red;"> * </span></label>
                                    <select id="selectWardid" name="ward_id" class="form-control" required>
                                      <option>Select ward</option>
                                    <?php if(!empty($ward)): ?>
                                                        <?php $__currentLoopData = $ward; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                        <option <?php if(isset($data)): ?>
                                                            <?php echo e($data->ward_id == $row->id  ? 'selected' : ''); ?>

                                                            <?php endif; ?> value="<?php echo e($row->id); ?>"><?php echo e($row->name); ?></option>

                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php endif; ?>
                                    </select>
                                  </div>
                 <?php else: ?>
              <div class="form-group col-md-4">
                                   <label for="inputState">Ward</label>
                                    <select id="selectWardid" name="ward_id" class="form-control" required>
                                      <option>Select ward</option>
                                    
                                    </select>
                                  </div>
  <?php endif; ?>
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

 <!-- discount Modal -->
  <div class="modal inmodal show " id="appFormModal" tabindex="-1" role="dialog" aria-hidden="true">
                          <div class="modal-dialog">
    </div>
</div></div>
  </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>



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
<script src="<?php echo e(url('assets/js/plugins/sweetalert/sweetalert.min.js')); ?>"></script>

<script>
$(document).ready(function() {

    $(document).on('change', '.region', function() {
        var id = $(this).val();
        $.ajax({
            url: '<?php echo e(url("findCenterDistrict")); ?>',
            type: "GET",
            data: {
                id: id
            },
            dataType: "json",
            success: function(response) {
                console.log(response);
                $("#selectDistrictid").empty();
                $("#selectDistrictid").append('<option value="">Select district</option>');
                $.each(response,function(key, value)
                {
                 
                    $("#selectDistrictid").append('<option value=' + value.id+ '>' + value.name + '</option>');
                   
                });                      
               
            }

        });

    });


 $(document).on('change', '.district', function() {
        var id = $(this).val();
        $.ajax({
            url: '<?php echo e(url("findCenterRegion")); ?>',
            type: "GET",
            data: {
                id: id
            },
            dataType: "json",
            success: function(response) {
                console.log(response);
                $("#selectWardid").empty();
                $("#selectWardid").append('<option value="">Select ward</option>');
                $.each(response,function(key, value)
                {
                 
                    $("#selectWardid").append('<option value=' + value.id+ '>' + value.name + '</option>');
                   
                });                      
               
            }

        });

    });



});
</script>


<script type="text/javascript">
    function model(id,type) {

        $.ajax({
            type: 'GET',
            url: '<?php echo e(url("centerModal")); ?>',
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
    
    

    function saveOperator(e){
  
          $.ajax({
            type: 'GET',
            url: '<?php echo e(url("addOperator")); ?>',
            data:  $('#addClientForm').serialize(),
               
                dataType: "json",
             success: function(response) {
                console.log(response);

                               var id = response.id;
                             var name = response.name;

                             var option = "<option value='"+id+"'  selected>"+name+" </option>"; 

                             $('#operator').append(option);
                              $('#appFormModal').hide();
                   
                               
               
            }
        });
}


    function saveLicence(e){
     
     
     var to = $('#destination_point').val();
     var distance = $('#distance').val();
     var from = $('#arrival_point').val();

     
          $.ajax({
            type: 'GET',
            url: '<?php echo e(url("addLicence")); ?>',
             data:  $('#addLicenceForm').serialize(),
              
          dataType: "json",
             success: function(response) {
                console.log(response);

                               var id = response.id;
                             var name = response.insurance_name;

                              var option = "<option value='"+id+"'  selected>"+name+" </option>"; 


                             $('#licence').append(option);
                              $('#appFormModal').hide();
                   
                               
               
            }
          
        });
}
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/admin/web/app.ema.co.tz/public_html/resources/views/cotton/center.blade.php ENDPATH**/ ?>