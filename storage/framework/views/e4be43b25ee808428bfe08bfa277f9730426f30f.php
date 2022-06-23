<?php $__env->startSection('content'); ?>
<section class="section">
    <div class="section-body">
        <?php echo $__env->make('layouts.alerts.message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Roles</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                           
                            <button type="button" class="btn btn-outline-info btn-xs px-4"
                            data-toggle="modal" data-target="#addRoleModal">
                        <i class="fa fa-plus-circle"></i>
                        Add
                    </button>


                        </ul>
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade <?php if(empty($id)): ?> active show <?php endif; ?>" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="table-1">
                                        <thead>
                                        <tr>
                        <th>S/N</th>
                        <th>Name</th>
                        <th>Permissions</th>
                        <th>Actions</th>
                    </tr>
                                        </thead>
                                        <tbody>
                        <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($role->added_by == auth()->user()->id): ?>
                            <tr>
                                <th><?php echo e($loop->iteration); ?></th>
                                <td><?php echo e($role->slug); ?></td>
                                <td align="right">
                                    <a href="<?php echo e(route('roles.show',$role->id)); ?>"
                                       class="btn btn-outline-info btn-xs"><i class="fas fa-plus-circle pr-1"></i> Assign </a>
                                </td>
                                <td align="right">
                                    <?php echo Form::open(['route' => ['roles.destroy', $role->id], 'method' => 'delete']); ?>

                                    <button type="button" class="btn btn-outline-info btn-xs edit_role_btn mr-1"
                                            data-toggle="modal"
                                            data-id="<?php echo e($role->id); ?>"
                                            data-name="<?php echo e($role->name); ?>"
                                            data-slug="<?php echo e($role->slug); ?>">
                                        <i class="fa fa-edit"></i> Edit
                                    </button>
                                    <?php echo e(Form::button('<i class="fas fa-trash"></i> Delete', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"])); ?>

                                    <?php echo e(Form::close()); ?>

                                </td>
                            </tr>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
</section>


<?php echo $__env->make('manage.role.add', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('manage.role.edit', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
        $(document).on('click', '.edit_role_btn', function () {
            let id = $(this).data('id');
            let name = $(this).data('name');
            let slug = $(this).data('slug');
            console.log("here");
            $('#r-id_').val(id);
            $('#r-slug_').val(slug);
            $('#r-name_').val(name);
            $('#editRoleModal').modal('show');
        });

    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/admin/web/gaki.ema.co.tz/public_html/resources/views/manage/role/index.blade.php ENDPATH**/ ?>