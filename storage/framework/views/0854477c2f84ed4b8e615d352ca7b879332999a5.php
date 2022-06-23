<style>
.p-md {
    padding: 12px !important;
}

.bg-items {
    background: #303252;
    color: #ffffff;
}
.ml-13 {
    margin-left: -13px !important;
}
</style>

<?php $__env->startSection('content'); ?>
<section class="section">
    <div class="section-body">


        <div class="row">


            <div class="col-12 col-md-12 col-lg-12">

               <div class="col-lg-10">
                 

              <?php if($purchases->collected == 0 && $purchases->status == 0 ): ?>                        
                <a class="btn btn-xs btn-danger " data-placement="top" title="Cancel" onclick="return confirm('Are you sure?')"   href="<?php echo e(route('pacel.cancel', $purchases->id)); ?>">Cancel Quotation  </a>   
                <a class="btn btn-xs btn-info " data-placement="top"  title="Collect" onclick="return confirm('Are you sure? you want to transport package')"  href="<?php echo e(route('pacel.approve', $purchases->id)); ?>">Transport Package </a> 
           <?php endif; ?>  
             
             <a class="btn btn-xs btn-success" href="<?php echo e(route('pacel_pdfview',['download'=>'pdf','id'=>$purchases->id])); ?>"  > Download PDF </a>         
                                         
    </div>

<br>

<?php if (strtotime($purchases->due_date) < time() && $purchases->status != '2' && $purchases->status != '7') {
    $start = strtotime(date('Y-m-d H:i'));
    $end = strtotime($purchases->due_date);

    $days_between = ceil(abs($end - $start) / 86400);
    ?>

   <div class="alert alert-danger alert-dismissible show fade">
            <div class="alert-body">
              <button class="close" data-dismiss="alert">
                <span>×</span>
              </button>
             <i class="fa fa-exclamation-triangle"></i>
        This invoice is overdue by <?php echo e($days_between); ?> days
            </div>
          </div>

  
    <?php
}
?>

<br>
 
                <div class="card">
                    <div class="padding-20">
                       
                        <?php
$settings= App\Models\System::first();


?>
                        <div class="tab-content" id="myTab3Content">
                            <div class="tab-pane fade show active" id="about" role="tabpanel"
                                aria-labelledby="home-tab2">
                                <div class="row">
                                   <div class="col-lg-6 col-xs-6 ">
                <img class="pl-lg" style="width: 153px;height: 120px;" src="<?php echo e(url('public/assets/img/logo')); ?>/<?php echo e($settings->picture); ?>">
            </div>
                                  
 <div class="col-lg-3 col-xs-3">

                                    </div>

                                      <div class="col-lg-3 col-xs-3">
                                        
                                       <h5 class=mb0">REF NO : <?php echo e($purchases->pacel_number); ?></h5>
                                      Invoice Date : <?php echo e(Carbon\Carbon::parse($purchases->date)->format('d/m/Y')); ?>                  
              <br>Due Date : <?php echo e(Carbon\Carbon::parse($purchases->due_date)->format('d/m/Y')); ?>                                          
           <br>Sales Agent: <?php echo e($purchases->user->name); ?> 
                                      
          <br>Status: 
            <?php if($purchases->status == 0 && $purchases->collected == 0): ?>
                                                    <div class="badge badge-danger badge-shadow">Not Approved</div>                                                   
                                              <?php elseif($purchases->collected == 1): ?>
                                            <div class="badge badge-success badge-shadow">Approved</div>
                                                  <?php elseif($purchases->status == 7 && $purchases->collected == 0): ?>
                                            <div class="badge badge-danger badge-shadow">Cancelled</div>
                                                    <?php endif; ?>

                                        <br>Currency: <?php echo e($purchases->currency_code); ?>                                                
                    
                    
                
            </div>
                                </div>


                               <br><br>
                               <div class="row mb-lg">
                                    <div class="col-lg-6 col-xs-6">
                                         <h5 class="p-md bg-items mr-15">Our Info:</h5>
                                 <h4 class="mb0"><?php echo e($settings->name); ?></h4>
                    <?php echo e($settings->address); ?>  
                   <br>Phone : <?php echo e($settings->phone); ?>     
                  <br> Email : <a href="mailto:<?php echo e($settings->email); ?>"><?php echo e($settings->email); ?></a>                                                               
                   <br>TIN : <?php echo e($settings->tin); ?>

                                    </div>
                                   

                                    <div class="col-lg-6 col-xs-6">
                                       
                                       <h5 class="p-md bg-items ml-13">  Customer Info: </h5>
                                       <h4 class="mb0"> <?php echo e($purchases->supplier->name); ?></h4>
                                      <?php echo e($purchases->supplier->address); ?>   
                                     <br>Phone : <?php echo e($purchases->supplier->phone); ?>                  
                                    <br> Email : <a href="mailto:<?php echo e($purchases->supplier->email); ?>"><?php echo e($purchases->supplier->email); ?></a>                                                               
                                    <br>TIN : <?php echo e(!empty($purchases->supplier->TIN)? $purchases->supplier->TIN : ''); ?>

                                        

                                        </div>
 </div>

                                    </div>
                                </div>

                                
                                <?php
                               
                                 $sub_total = 0;
                                 $gland_total = 0;
                                 $tax=0;
                                 $i =1;
       
                                 ?>

                               <div class="table-responsive mb-lg">
            <table class="table items invoice-items-preview" page-break-inside:="" auto;="">
                <thead class="bg-items">
                    <tr>
                        <th style="color:white;">#</th>
                        <th style="color:white;">Route Name</th>
                  <th style="color:white;">Charge Type</th>
                        <th style="color:white;">Qty</th>
                        <th  style="color:white;">Price</th>
                        <th style="color:white;">Tax</th>
                        <th style="color:white;">Total</th>
                    </tr>
                </thead>
                                    <tbody>
                                        <?php if(!empty($purchase_items)): ?>
                                        <?php $__currentLoopData = $purchase_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                         $sub_total +=$row->total_cost;
                                         $gland_total +=$row->total_cost +$row->total_tax;
                                         $tax += $row->total_tax; 
                                         ?>
                                        <tr>
                                            <td class=""><?php echo e($i++); ?></td>
                                            <?php
                                          //$item_name = App\Models\Pacel\PacelList::find($row->item_name);
                                          $item_name = App\Models\Route::find($row->item_name);
                                        ?>
                                            <td class=""><strong class="block">From <?php echo e($item_name->from); ?>  to  <?php echo e($item_name->to); ?> (<?php echo e($row->distance); ?> km)</strong></td>
                                           <td class=""><?php echo e($row->charge_type); ?> </td>
                                            <td class=""><?php echo e($row->quantity); ?> </td>
                                        <td class=""><?php echo e(number_format($row->price ,2)); ?>  </td>                                         
                                         <td class="">
                                  <?php if(!@empty($row->total_tax > 0)): ?>
                              <?php echo e(number_format($row->total_tax ,2)); ?> 
<?php endif; ?>
</td>
                                            <td class=""><?php echo e(number_format($row->total_cost ,2)); ?> </td>
                                            
                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>

                                       
                                    </tbody>
</table>
                            </div>

                                     <div class="row" >
                                              <div class="col-lg-8"> </div>
                                        <div class="col-lg-4 pv">

                <div class="clearfix">
                    <p class="pull-left">Sub Total</p>
                    <p class="pull-right mr"><?php echo e(number_format($sub_total,2)); ?>  <?php echo e($purchases->currency_code); ?></p>
                </div>

          <?php if(!@empty($tax > 0)): ?>
        <div class="clearfix">
                    <p class="pull-left">Total Tax - VAT (18 %)</p>
                    <p class="pull-right mr"><?php echo e(number_format($tax,2)); ?>  <?php echo e($purchases->currency_code); ?></p>
                </div>
  <?php endif; ?>

 <?php if(!@empty($purchases->discount > 0)): ?>
        <div class="clearfix">
                    <p class="pull-left">Discount</p>
                    <p class="pull-right mr"><?php echo e(number_format($purchases->discount,2)); ?>  <?php echo e($purchases->currency_code); ?></p>
                </div>
<?php endif; ?>
 <div class="clearfix">
                    <p class="pull-left">Total Amount</p>
                    <p class="pull-right mr"><?php echo e(number_format($gland_total - $purchases->discount ,2)); ?>  <?php echo e($purchases->currency_code); ?></p>
                </div>



  <?php if(!@empty($purchases->due_amount < $purchases->amount)): ?>
        <div class="clearfix">
                    <p class="pull-left">Paid Amount</p>
                    <p class="pull-right mr"><?php echo e(number_format($purchases->amount - $purchases->due_amount,2)); ?>  <?php echo e($purchases->currency_code); ?></p>
                </div>

      <div class="clearfix">
                    <p class="pull-left h3 text-danger">Total Due</p>
                    <p class="pull-right mr"><?php echo e(number_format($purchases->due_amount,2)); ?>  <?php echo e($purchases->currency_code); ?></p>
                </div>
<?php endif; ?>

<br>
 <?php if($purchases->currency_code != 'TZS'): ?>
 <b>Exchange Rate 1 <?php echo e($purchases->currency_code); ?> = <?php echo e($purchases->exchange_rate); ?> TZS</b>
<p></p>
<br>
                <div class="clearfix">
                    <p class="pull-left">Sub Total</p>
                    <p class="pull-right mr"><?php echo e(number_format($sub_total * $purchases->exchange_rate,2)); ?>  TZS</p>
                </div>

          <?php if(!@empty($tax > 0)): ?>
        <div class="clearfix">
                    <p class="pull-left">Total Tax</p>
                    <p class="pull-right mr"><?php echo e(number_format($tax * $purchases->exchange_rate,2)); ?>   TZS</p>
                </div>
  <?php endif; ?>

 <?php if(!@empty($purchases->discount > 0)): ?>
        <div class="clearfix">
                    <p class="pull-left">Discount</p>
                    <p class="pull-right mr"><?php echo e(number_format($purchases->discount * $purchases->exchange_rate,2)); ?>   TZS</p>
                </div>
<?php endif; ?>
 <div class="clearfix">
                    <p class="pull-left">Total Amount</p>
                    <p class="pull-right mr"><?php echo e(number_format($purchases->exchange_rate * ($gland_total-$purchases->discount) ,2)); ?>   TZS</p>
                </div>



  <?php if(!@empty($purchases->due_amount < $purchases->amount)): ?>
        <div class="clearfix">
                    <p class="pull-left">Paid Amount</p>
                    <p class="pull-right mr"><?php echo e(number_format($purchases->exchange_rate * ($purchases->amount - $purchases->due_amount),2)); ?>  TZS</p>
                </div>

      <div class="clearfix">
                    <p class="pull-left h3 text-danger">Total Due</p>
                    <p class="pull-right mr"><?php echo e(number_format($purchases->due_amount * $purchases->exchange_rate,2)); ?>  TZS</p>
                </div>
<?php endif; ?>

<?php endif; ?>



</div>

                                
                             
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
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/admin/web/del.co.tz/public_html/resources/views/pacel/quotation_details.blade.php ENDPATH**/ ?>