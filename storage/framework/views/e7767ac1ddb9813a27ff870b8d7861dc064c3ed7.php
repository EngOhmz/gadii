<?php $__env->startSection('content'); ?>
<section class="section">
    <div class="section-body">
        <div class="row">

            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="padding-20">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="home-tab2" data-toggle="tab" href="#about" role="tab"
                                    aria-selected="true"><?php echo e(__('ordering.quotation_detail')); ?></a>
                            </li>
                                                    
                            <li class="nav-item">
                                <a class="nav-link" id="profile-tab2"
                                    href="<?php echo e(route('order.pay',$quotation->id)); ?>" role="tab"
                                    aria-selected="false"><?php echo e(__('ordering.quotation_confirm')); ?> 
                                    </a>
                            </li>
                      
                        </ul>
                        <?php
$settings= App\Models\System::first();


?>
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade show active" id="about" role="tabpanel"
                                aria-labelledby="home-tab2">
                                <div class="row">
                    
                                    <div class="col-md-12 col-6 b-r">
                                    <center> <p><?php echo e(__('ordering.Quotation_Costs')); ?>  </p> </center>
                                    </div>
                                    <div class="col-md-12 col-6 b-r">
                                    <center><p><b><?php echo e(__('ordering.company_name')); ?> <?php echo e($quotation->user->name); ?> </b>  </p> </center>
                                    </div>

                           
                                </div>
                                <hr>
                               
                                <?php
                               
                                 $sub_total = 0;
                                 $gland_total = 0;
                                 $tax=0;
                                 $i =1;
       
                                 ?>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">DESCRIPTION</th>
                                            <th scope="col">UNIT PRICE</th>
                                            <th scope="col">QUANTITY</th>
                                            <th scope="col">TOTAL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(!empty($quotation->quotation_cost)): ?>
                                        <?php $__currentLoopData = $quotation->quotation_cost; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                         $sub_total +=$row->total_cost;
                                         $gland_total +=$row->total_cost +$row->total_tax;
                                         $tax += $row->total_tax; 
                                         ?>
                                        <tr>
                                            <td class=""><?php echo e($i++); ?></td>
                                            <?php
                                          $item_name = App\Models\orders\Cost_function::find($row->item_name);
                                        ?>
                                            <td class="">
                                                <p style="padding-right:80px;"><?php echo e($item_name->name); ?></p>
                                            </td>
                                            <td class=""><?php echo e($row->price); ?> <?php echo e($quotation->currency_code); ?></td>
                                            <td class=""><?php echo e($row->quantity); ?> <?php echo e($quotation->currency_code); ?></td>
                                            <td class=""><?php echo e($row->total_cost); ?> <?php echo e($quotation->currency_code); ?></td>
                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>


                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="2"></td>
                                            <td colspan="2">
                                                <hr>SUBTOTAL
                                                </hr>
                                            </td>
                                            <td>
                                                <hr><?php echo e(number_format($sub_total,2)); ?> <?php echo e($quotation->currency_code); ?>

</hr>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"></td>
                                            <td colspan="2">
                                                <hr>TAX 18%
                                                <hr>
                                            </td>
                                            <td>
                                                <hr><?php echo e(number_format($tax,2)); ?> <?php echo e($quotation->currency_code); ?>

                                                <hr>
                                            </td>
                                        </tr>
                                        <?php if(!@empty($pacel->discount > 0)): ?>
                                        <tr>
                                            <td colspan="2"></td>
                                            <td colspan="2">
                                                DISCOUNT</td>
                                            <td><?php echo e($pacel->discount); ?> <?php echo e($quotation->currency_code); ?></td>
                                        </tr>
                                        <?php endif; ?>
                                        <tr>
                                            <td colspan="2"></td>
                                            <td colspan="2">
                                                GRAND TOTAL
                                            </td>
                                            <td>
                                                <?php echo e(number_format($gland_total - $quotation->discount,2)); ?>

                                                <?php echo e($quotation->currency_code); ?>

                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                                <hr>
                            </div>

                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
</section>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/admin/web/app.ema.co.tz/public_html/resources/views/orders/orders_details.blade.php ENDPATH**/ ?>