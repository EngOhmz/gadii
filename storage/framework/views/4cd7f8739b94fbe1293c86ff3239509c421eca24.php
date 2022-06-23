<?php $__env->startSection('content'); ?>

  <section class="section">
    <div class="section-body">
      <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
          <!-- alert -->
          <?php if(Session::get('messagev')): ?>
          <div class="alert alert-success alert-dismissible show fade">
            <div class="alert-body">
              <button class="close" data-dismiss="alert">
                <span>×</span>
              </button>
              <?php echo e(Session::get('messagev')); ?>

            </div>
          </div>
          <?php endif; ?>
          <?php if(Session::get('messager')): ?>)
          <div class="alert alert-danger alert-dismissible show fade">
            <div class="alert-body">
              <button class="close" data-dismiss="alert">
                <span>×</span>
              </button>
              <?php echo e(Session::get('messager')); ?>

            </div>
          </div>
           <?php endif; ?>

          <!-- end of alert -->
          <div class="card">
            <div class="card-header">
              <h4><?php echo e(__('farmer.manage_farmer')); ?></h4>
            </div>
            <div class="card-body">

                  <ul class="nav nav-tabs" id="myTab4" role="tablist">
                     <li class="nav-item">
                      <a class="nav-link <?php if(empty($id)): ?> active show <?php endif; ?>" id="profile-tab4" data-toggle="tab" href="#profile4" role="tab" aria-controls="profile" aria-selected="true">Farmer List</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link <?php if(!empty($id)): ?> active show <?php endif; ?>" id="home-tab4" data-toggle="tab" href="#home4" role="tab" aria-controls="home" aria-selected="false">Register Farmer </a>
                    </li>
                   
                 
                  </ul>
                
 <div class="tab-content tab-bordered" id="myTab3Content">
                 <div class="tab-pane fade <?php if(empty($id)): ?> active show <?php endif; ?>"  id="profile4" role="tabpanel" aria-labelledby="profile-tab4">
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
                                                    style="width: 141.219px;">Phone</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Email</th> 
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Location</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Actions</th>
                                            </tr>
                                        </thead>
                              <tbody>
                          
                              
                              <?php $__currentLoopData = $farm; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $flist): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                  <tr class="gradeA even" role="row">
                           <td><?php echo e($loop->iteration); ?></td>
                                   <td><?php echo e($flist->firstname); ?> <?php echo e($flist->lastname); ?></td>
                                <td><?php echo e($flist->phone); ?></td>
                                <td><?php echo e($flist->email); ?></td>

                                <td><?php echo e($flist->ward->name); ?>, <?php echo e($flist->district->name); ?>,<?php echo e($flist->region->name); ?></td>
                                <td>
                                  <div class="row">
                                    <div class="col-lg-12 col-sm-12 col-md-12">
                                  <a href="farmer/<?php echo e($flist->id); ?>/show" ><i class="fas fa-tv"></i></a>
                                  <a href="farmer/<?php echo e($flist->id); ?>/edit"><i class="fas fa-edit"></i></a>
                                  <a href="#"  data-toggle="modal" data-target="#basicModal"><i class="fas fa-trash-alt"></i></a>
                                  
                                    </div>
                                </td>
                                 </tr>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            
                              

                            </tbody>
         
                  
                            
                          </table>
                      
                          </div>
                          
                    </div>
             

                    <div class="tab-pane fade <?php if(!empty($id)): ?> active show <?php endif; ?>"  id="home4" role="tabpanel" aria-labelledby="home-tab4">
                      <div class="card">
                        <div class="card-header">
                         <?php if(!empty($id)): ?>
                                            <h5>Edit Farmer</h5>
                                            <?php else: ?>
                                            <h5>Add New Farmer</h5>
                                            <?php endif; ?>

                        </div>
                        <div class="card-body ">
                           <div class="row">
                                            <div class="col-sm-12 ">
                                             <?php if(isset($id)): ?>
                                                   <form class="form" method="post" action="<?php echo e(url('farmer/update',$farmer->id)); ?>">
                                                 <?php echo e(csrf_field()); ?>

                                                    <?php else: ?>
                                                  <form class="form" method="post" action="<?php echo e(url('farmer/save')); ?>">
                                                  <?php echo e(csrf_field()); ?>

                                                    <?php endif; ?>
                         

                                <div class="form-row">
                                <div class="form-group col-md-6">
                                  <label for="inputEmail4">FirstName</label>
                                  <input type="text" name='firstname' class="form-control" id="inputEmail4" placeholder="" value="<?php echo e(isset($farmer) ? $farmer->firstname : ' '); ?>">
                                      <?php $__errorArgs = ['firstname'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                          
                                <div class="form-group col-md-6">
                                  <label for="inputPassword4">LastName</label>
                                  <input type="text" name='lastname' class="form-control" id="inputPassword4" placeholder="" value="<?php echo e(isset($farmer) ? $farmer->lastname : ''); ?>">
                                   <?php $__errorArgs = ['lastname'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text text-danger"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            
                                </div>

                                <div class="form-row">
                                 <div class="form-group col-md-6 col-lg-6">
                                  <label for="inputAddress">Phone number</label>
                                  <input type="text" name='phone' class="form-control" id="inputAddress" placeholder="" value="<?php echo e(isset($farmer) ? $farmer->phone : ''); ?>">
                                  <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                  <div class="text text-danger"><?php echo e($message); ?></div>
                              <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> 
                                </div>
                                  <div class="form-group col-md-6 col-lg-6">
                                  <label for="inputAddress">Email</label>
                                  <input type="email" name='email' class="form-control" id="inputAddress" placeholder="example@example.com (optional)" value="<?php echo e(isset($farmer) ? $farmer->email : ''); ?>">
                                  </div>
                                </div>

                                <div class="form-row">
                                  <div class="form-group col-md-4">
                                    <label for="inputState">Region</label>
                                    <select  id="selectRegionid" name="region_id" class="form-control region">
                                      <option ="">Select region</option>
                                      <?php if(!empty($region)): ?>
                                                        <?php $__currentLoopData = $region; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                        <option <?php if(isset($farmer)): ?>
                                                            <?php echo e($farmer->region_id == $row->id  ? 'selected' : ''); ?>

                                                            <?php endif; ?> value="<?php echo e($row->id); ?>"><?php echo e($row->name); ?></option>

                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php endif; ?>
                                    </select>
                                  </div>

                     <?php if(!empty($farmer)): ?>
                      <div class="form-group col-md-4">
                                    <label for="inputState">District</label>
                                    <select id="selectDistrictid" name="district_id" class="form-control district">
                                      <option>Select district</option>
                                    <?php if(!empty($district)): ?>
                                                        <?php $__currentLoopData = $district; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                        <option <?php if(isset($farmer)): ?>
                                                            <?php echo e($farmer->district_id == $row->id  ? 'selected' : ''); ?>

                                                            <?php endif; ?> value="<?php echo e($row->id); ?>"><?php echo e($row->name); ?></option>

                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php endif; ?>
                                    </select>
                                  </div>
                 <?php else: ?>
              <div class="form-group col-md-4">
                                    <label for="inputState">District</label>
                                    <select id="selectDistrictid" name="district_id" class="form-control district">
                                      <option selected="">Select district</option>
                                    
                                    </select>
                                  </div>
  <?php endif; ?>
                            
            
 <?php if(!empty($farmer)): ?>
                      <div class="form-group col-md-4">
                                    <label for="inputState">Ward</label>
                                    <select id="selectWardid" name="ward_id" class="form-control">
                                      <option>Select ward</option>
                                    <?php if(!empty($ward)): ?>
                                                        <?php $__currentLoopData = $ward; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                        <option <?php if(isset($farmer)): ?>
                                                            <?php echo e($farmer->ward_id == $row->id  ? 'selected' : ''); ?>

                                                            <?php endif; ?> value="<?php echo e($row->id); ?>"><?php echo e($row->name); ?></option>

                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php endif; ?>
                                    </select>
                                  </div>
                 <?php else: ?>
              <div class="form-group col-md-4">
                                   <label for="inputState">Ward</label>
                                    <select id="selectWardid" name="ward_id" class="form-control">
                                      <option>Select ward</option>
                                    
                                    </select>
                                  </div>
  <?php endif; ?>
                             </div>
            

    <div class="form-row">
                                  <div class="form-group col-md-6">
                                    <label for="inputCity">Physical Address</label>
                                    <input type="text" name="address" class="form-control" id="inputCity" value="<?php echo e(isset($farmer) ? $farmer->address : ''); ?>">
                                    <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="text text-danger"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                  </div>
                               
                                  <div class="form-group col-md-6">
                                    <label for="inputState">Group</label>
                                    <select id="inputState" name="group_id" class="form-control">
                                      <option value="0" selected="">Select group</option>
                                    <?php if(isset($group)): ?>
                                    <?php $__currentLoopData = $group; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                      <option  <?php if(isset($data)): ?>
                                                            <?php echo e($farmer->group_id == $group->id ? 'selected' : ''); ?>

                                                            <?php endif; ?>  value="<?php echo e($group->id); ?>"><?php echo e($group->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                    </select>
                                  </div>
                                  </div>
                                <!--
                                <div class="form-row">
                                  <div class="form-group col-md-6 col-lg-6">
                                  <label for="inputState">Region</label>
                                  <select id="inputState" class="form-control">
                                  <option selected="">Choose...</option>
                                  <option>...</option>
                                  </select>
                                  </div>
                                  <div class="form-group col-md-6 col-lg-6">
                                  <label for="inputCity">Physical Address</label>
                                  <input type="text" class="form-control" id="inputCity">
                                  </div>
                                </div>
                              -->
                               <div class="form-row">
                                 <div class="col-lg-offset-2 col-lg-12">
                         <?php if(!@empty($id)): ?>
                                                        <input type="submit" value="Update" name="save" class="btn btn-lg btn-info">
                                                        <?php else: ?>
                                                        <input type="submit" value="Save" name="save" class="btn btn-lg btn-primary">
                                                        <?php endif; ?>
                                
                               </div>
                                </div>
                              </div>
                      </form>
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
  <!-- delete modal -->
  <div class="modal fade" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete?
      </div>
      <div class="modal-footer bg-whitesmoke br">
        <button type="button" type="submit"  class="btn btn-danger"><a href="farmer/<?php echo e($flist->id ?? ''); ?>/delete" style="color:white;font-weight:bold">Delete</a></button>
        <button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- end of the delete model -->

<script>
$(document).ready(function() {

    $(document).on('change', '.region', function() {
        var id = $(this).val();
        $.ajax({
            url: '<?php echo e(url("findRegion")); ?>',
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
            url: '<?php echo e(url("findDistrict")); ?>',
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/admin/web/app.ema.co.tz/public_html/resources/views/agrihub/manage-farmer.blade.php ENDPATH**/ ?>